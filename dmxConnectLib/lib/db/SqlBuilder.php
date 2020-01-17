<?php

namespace lib\db;

use \lib\App;
use \lib\db\Connection;

class SqlBuilder
{
    public $app;
    public $connection;
    public $type;
    public $distinct;
    public $table;
    public $joins;
    public $values;
    public $wheres;
    public $groupBy;
    public $orders;
    public $columns;
    public $params;
    public $sortables;
    public $offset;
    public $limit;

    public function __construct(App $app, Connection $connection) {
        $this->app = $app;
        $this->connection = $connection;
        $this->reset();
    }

    public function reset() {
        $this->type = 'select';
        $this->distinct = FALSE;
        $this->table = '';
        $this->joins = array();
        $this->values = array();
        $this->wheres = array();
        $this->groupBy = array();
        $this->orders = array();
        $this->columns = array();
        $this->params = array();
        $this->sortables = array();
        $this->offset = 0;
        $this->limit = 0;
    }

    public function fromJSON($json) {
        if (is_string($json)) {
            $json = json_decode($json);
        }

		$props = array('type', 'table', 'joins', 'values', 'wheres', 'groupBy', 'orders', 'columns', 'params', 'sortables', 'offset', 'limit', 'distinct');
		foreach ($props as $prop) {
			if (isset($json->$prop)) {
				$this->$prop = $json->$prop;
			}
		}
    }

    public function select($columns = NULL) {
        $this->type = 'select';

        if ($columns === NULL) {
            return $this;
        }

        if (!is_array($columns)) {
            $columns = func_get_args();
        }

        $this->columns = array_unique(array_merge($this->columns, $columns));

        return $this;
    }

    public function count() {
        $this->type = 'count';
        return $this;
    }

    public function insert(array $values) {
        $this->type = 'insert';
        $this->values = $values;
        return $this;
    }

    public function update(array $values) {
        $this->type = 'update';
        $this->values = $values;
        return $this;
    }

    public function delete() {
        $this->type = 'delete';
        return $this;
    }

    public function from($table = NULL) {
        if ($table === NULL) {
            return $this->table;
        }

        $this->table = $table;
        return $this;
    }

    public function join($table, $column, $operator, $value, $type = 'INNER') {
        $this->joins[] = (object)array(
            'table'    => $table,
            'column'   => $column,
            'operator' => $operator,
            'value'    => $value,
            'type'     => $type
        );

        return $this;
    }

    public function where($column, $operator, $value, $bool = 'AND') {
        $table = $this->table;

        if (is_object($column)) {
            if (isset($column->table)) {
                $table = $column->table;
            }

            $column = $column->column;
        }

        $this->wheres[] = (object)array(
            'table'    => $table,
            'column'   => $column,
            'operator' => $operator,
            'value'    => $value,
            'bool'     => $bool
        );

        return $this;
    }

    public function andWhere($column, $operator, $value) {
        return $this->where($column, $operator, $value);
    }

    public function orWhere($column, $operator, $value) {
        return $this->where($column, $operator, $value, 'OR');
    }

    public function orderBy($column, $direction = 'ASC') {
        $this->orders[] = (object)array(
            'column'    => $column,
            'direction' => $direction
        );

        return $this;
    }

    public function setDistinct($distinct) {
        $this->distinct = $distinct;
        return $this;
    }

    public function offset($offset) {
        $this->offset = $offset;
        return $this;
    }

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function quoteIdentifier($value) {
        if (preg_match('/\s+AS\s+/i', $value)) {
            $segments = preg_split('/\s+AS\s+/i', $value);
            return $this->quote($this->quoteIdentifier($segments[0])) . ' AS ' . $this->quote($this->quoteIdentifier($segments[1]));
        }

        return implode('.', array_map(array($this, 'quote'), explode('.', $value)));
    }

    public function quote($value) {
        if ($value == '*') return '*';
        return $this->connection->server->quoteIdentifier($value);
    }

    public function __toString() {
        if (isset($this->query)) {
            return $this->query;
        }

        return $this->compile();
    }

    public function compile() {
        $this->params = array();
        $this->query = preg_replace('/ +/', ' ', trim($this->{'compile' . ucfirst($this->type)}()));
        return $this->query;
    }

    private function compileSelect() {
        $components = array('columns', 'from', 'joins', 'wheres', 'groupBy', 'orders');

        if (count($this->columns) == 0) {
            $this->columns[] = '*';
        }

        return $this->connection->server->limitQuery('SELECT' . ($this->distinct ? ' DISTINCT ' : ' ') . implode(' ', array_map(array($this, 'compileComponent'), $components)), $this->limit, $this->offset);
    }

    private function compileCount() {
        $components = array('columns', 'from', 'joins', 'wheres', 'groupBy');

        if (count($this->columns) == 0) {
            $this->columns[] = '*';
        }

        return 'SELECT COUNT(*) AS Total FROM (SELECT' . ($this->distinct ? ' DISTINCT ' : ' ') . implode(' ', array_map(array($this, 'compileComponent'), $components)) . ') AS dt';
    }

    private function compileInsert() {
        return 'INSERT INTO ' . $this->quoteIdentifier($this->table) . ' (' . implode(', ', array_map(array($this, 'compileColumn'), $this->values)) . ') VALUES (' . $this->compileParameters($this->values) . ')';
    }

    private function compileUpdate() {
        return 'UPDATE ' . $this->quoteIdentifier($this->table) . ' ' . $this->compileSet($this->values) . ' ' . $this->compileWheres($this->wheres);
    }

    private function compileDelete() {
        return 'DELETE FROM ' . $this->quoteIdentifier($this->table) . ' ' . $this->compileWheres($this->wheres);
    }

    private function compileComponent($component) {
		$result = method_exists($this, $component) ? $this->$component() : @$this->$component;
		return $this->{'compile' . ucfirst($component)}($result);
    }

    private function compileColumns($columns) {
        return implode(', ', array_map(array($this, 'compileColumn'), $columns));
    }

    private function compileColumn($column) {
        $prefix = '';
        $suffix = '';

        if ($column == '*') {
            return $column;
        }

        if (!is_object($column)) {
            $column = (object)array(
                'table'  => $this->table,
                'column' => $column
            );
        }

        if (!isset($column->table)) {
            $column->table = $this->table;
        }

        if (isset($column->aggregate) && $column->aggregate != '') {
            $prefix .= $column->aggregate . '(';
            if (isset($column->distinct) && $column->distinct === TRUE) {
              $prefix .= 'DISTINCT ';
            }
            $suffix .= ')';
        }

        if (!empty($this->joins) && isset($column->table)) {
            $prefix .= $this->quoteIdentifier($column->table) . '.';
        }

        if (isset($column->alias) && $column->alias != '') {
            $suffix .= ' AS ' . $this->quoteIdentifier($column->alias);
        }

        return $prefix . $this->quoteIdentifier($column->column) . $suffix;
    }

    private function compileFrom($table) {
        return 'FROM ' . $this->quoteIdentifier(isset($table->name) ? $table->name : $table) . (isset($table->alias) ? ' AS ' . $this->quoteIdentifier($table->alias) : '');
    }

    private function compileJoins($joins) {
        return implode(' ', array_map(array($this, 'compileJoin'), $joins));
    }

    private function compileJoin($join) {
        return strtoupper($join->type) . ' JOIN ' . $this->quoteIdentifier($join->table) . (isset($join->alias) && $join->alias != '' ? ' AS ' . $this->quoteIdentifier($join->alias) : '') . str_replace('WHERE', ' ON', $this->compileWheres($join->clauses));
    }

    private function compileSet($values) {
        return 'SET ' . implode(', ', array_map(array($this, 'compileSetValue'), $values));
    }

    private function compileSetValue($value) {
        return $this->compileColumn($value) . ' = ' . $this->compileParameter($value);
    }

    private function compileWheres($wheres) {
      	if (is_array($wheres)) {
            if (count($wheres) == 0) return '';

            return 'WHERE ' . preg_replace('/^(AND|OR)\s*/i', '', implode(' ', array_map(array($this, 'compileWhere'), $wheres)));
        }

      	if (is_object($wheres)) {
          	return 'WHERE ' . $this->compileWhereExpression($wheres);
        }

      	return '';
    }

    private function compileGroupBy($groupBy) {
        if (!empty($groupBy)) {
          return 'GROUP BY ' . implode(', ', array_map(array($this, 'compileColumn'), $groupBy));
        }
    }

  	private function compileWhereExpression($where) {
      	if (!isset($where->condition)) {
          	if (in_array($where->operator, array('between', 'not_between'))) {
              	return implode(' ', array($this->compileColumn(isset($where->data) ? $where->data : $where), $where->operation, $this->compileParameter($where, 0), 'AND', $this->compileParameter($where, 1)));
            }

          	if (in_array($where->operator, array('is_null', 'not_is_null'))) {
              	return implode(' ', array($this->compileColumn(isset($where->data) ? $where->data : $where), $where->operation));
            }

          	if (in_array($where->operator, array('in', 'not_in'))) {
              	return implode(' ', array($this->compileColumn(isset($where->data) ? $where->data : $where), $where->operation, '(' . $this->compileParameters($where) . ')'));
            }

          	$param = $this->compileParameter($where);

            if (in_array($where->operator, array('begins_with', 'not_begins_with'))) {
                $param = $this->connection->server->concatExpression($param, "'%'") . " ESCAPE '!'";
            } elseif (in_array($where->operator, array('ends_with', 'not_ends_with'))) {
                $param = $this->connection->server->concatExpression("'%'", $param) . " ESCAPE '!'";
            } elseif (in_array($where->operator, array('contains', 'not_contains'))) {
                $param = $this->connection->server->concatExpression("'%'", $param, "'%'") . " ESCAPE '!'";
            }

          	return implode(' ', array($this->compileColumn(isset($where->data) ? $where->data : $where), $where->operation, $param));
        }

      	return '(' . implode(' ' . $where->condition . ' ', array_map(array($this, 'compileWhereExpression'), $where->rules)) . ')';
    }

    private function compileWhere($where) {
        $type = 'Basic';

        switch ($where->operator) {
            case 'in': case 'not in':
                $type = 'In';
                break;
            case 'is null':
            case 'is not null':
                $type = 'Null';
                break;
            case 'starts with':
            case 'not starts with':
            case 'ends with':
            case 'not ends with':
            case 'contains':
            case 'not contains':
                $type = 'Like';
                $where->type = 'string';
                $where->length = 255;
                break;
            case 'between':
                $type = 'Between';
                break;
        }

		if (!isset($where->bool)) $where->bool = 'AND';

        return strtoupper($where->bool) . ' ' . $this->{'compileWhere' . $type}($where);
    }

    private function compileWhereBasic($where) {
        return $this->compileColumn($where) . ' ' . $where->operator . ' ' . $this->compileParameter($where);
    }

    private function compileWhereBetween($where) {
        return $this->compileColumn($where) . ' BETWEEN ' . $this->compileParameter($where, 0) . ' AND ' . $this->compileParameter($where, 1);
    }

    private function compileWhereIn($where) {
        return $this->compileColumn($where) . ' ' . strtoupper($where->operator) . ' (' . $this->compileParameters($where) . ')';
    }

    private function compileWhereNull($where) {
        return $this->compileColumn($where) . strtoupper($where->operator);
    }

    private function compileWhereLike($where) {
        return str_replace(array('{column}', '{value}'), array($this->compileColumn($where), $this->compileParameter($where)), $this->connection->server->likeFormat($where->operator));
    }

    private function compileOrders($orders) {
        if (count($orders) == 0) return '';

        return 'ORDER BY ' . implode(', ', array_map(array($this, 'compileOrder'), $orders));
    }

    private function compileOrder($order) {
        //@unset($order->alias);
        return $this->compileColumn($order) . ' ' . $order->direction;
    }

    private function compileParameters($params) {
        if (!is_array($params)) {
            $values = $params->value;

            if (is_array($values)) {
                $org = clone $params;
                $params = array();

                for ($i = 0; $i < count($values); $i++) {
                    $param = clone $org;
                    $param->value = $values[$i];
                    array_push($params, $param);
                }
            } else {
                $params = array($params);
            }
        }

        return implode(', ', array_map(array($this, 'compileParameter'), $params));
    }

    private function compileParameter($obj, $index = NULL) {
        if (isset($obj->value) && isset($obj->value->column)) {
            return $this->compileColumn($obj->value);
        }

        $param = clone $obj;

        if ($index !== NULL) {
            $param->value = $param->value[$index];
        }

        $this->params[] = $param;

        return '?';
    }
}
