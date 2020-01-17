<?php

namespace modules;

use \lib\core\Module;
use \lib\db\Connection;
use \lib\db\SqlBuilder;

class dbconnector extends Module
{
    public function connect($options) {
        return new Connection($this->app, $this->app->parseObject($options));
    }

    public function select($options) {
        option_require($options, 'connection');
        option_require($options, 'sql');
        option_require($options->sql, 'table');
        option_default($options->sql, 'sort', '{{$_GET.sort}}');
        option_default($options->sql, 'dir', '{{$_GET.dir}}');

        $options = $this->parseOptions($options);

        $options->sql->type = 'select';

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        if (!isset($options->sql->orders)) {
            $options->sql->orders = array();
        }

        if (isset($options->sql->sort)) {
          foreach ($options->sql->columns as $column) {
            if ($column->column == $options->sql->sort || (isset($column->alias) && $column->alias == $options->sql->sort)) {
              $order = (object)array(
                'column' => $column->column,
                'direction' => isset($options->sql->dir) && strtoupper($options->sql->dir) == 'DESC' ? 'DESC' : 'ASC'
              );

              if (isset($column->table)) {
                  $order->table = $column->table;
              }

              array_unshift($options->sql->orders, $order);
              break;
            }
          }
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
        $sql->compile();

		if (isset($options->test)) {
			return (object)array(
                'options' => $options,
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params);
    }

    public function single($options) {
      option_require($options, 'connection');
      option_require($options, 'sql');
      option_require($options->sql, 'table');

      $options = $this->parseOptions($options);

      $options->sql->type = 'select';

      $connection = $this->app->scope->get($options->connection);

      if ($connection === NULL) {
          throw new \Exception('Connection "' . $options->connection . '" not found.');
      }

      $sql = new SqlBuilder($this->app, $connection);

      $sql->fromJSON($options->sql);
      $sql->compile();

      if (isset($options->test)) {
          return (object)array(
              'options' => $options,
              'query' => $sql->query,
              'params' => $sql->params
          );
      }

      $results = $connection->execute($sql->query, $sql->params);

      return count($results) ? $results[0] : NULL;
  }

    public function count($options) {
        option_require($options, 'connection');
        option_require($options, 'sql');
        option_require($options->sql, 'table');

        $options = $this->parseOptions($options);

        $options->sql->type = 'count';

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
        $sql->compile();

    		if (isset($options->test)) {
    			return (object)array(
            'options' => $options,
    				'query' => $sql->query,
    				'params' => $sql->params
    			);
    		}

        $result = $connection->execute($sql->query, $sql->params);

        return $result[0]['Total'];
    }

    public function paged($options) {
        option_require($options, 'connection');
        option_require($options, 'sql');
        option_require($options->sql, 'table');
        option_default($options->sql, 'offset', '{{$_GET.offset}}');
        option_default($options->sql, 'limit', '{{$_GET.limit}}');
        option_default($options->sql, 'sort', '{{$_GET.sort}}');
        option_default($options->sql, 'dir', '{{$_GET.dir}}');

        $options = $this->parseOptions($options);

        if (is_null($options->sql->offset)) $options->sql->offset = 0;
        if (is_null($options->sql->limit)) $options->sql->limit = 25;

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        if (!isset($options->sql->orders)) {
            $options->sql->orders = array();
        }

        if (isset($options->sql->sort)) {
          foreach ($options->sql->columns as $column) {
            if ($column->column == $options->sql->sort || (isset($column->alias) && $column->alias == $options->sql->sort)) {
              $order = (object)array(
                'column' => $column->column,
                'direction' => isset($options->sql->dir) && strtoupper($options->sql->dir) == 'DESC' ? 'DESC' : 'ASC'
              );

              if (isset($column->table)) {
                  $order->table = $column->table;
              }

              array_unshift($options->sql->orders, $order);
              break;
            }
          }
        }

        $sql = new SqlBuilder($this->app, $connection);

        $options->sql->type = 'count';
        $sql->fromJSON($options->sql);
        $sql->compile();
        $result = $connection->execute($sql->query, $sql->params);
        $total = 0;
        // Check if Total is available (prevent error)
        if (isset($result[0]['Total'])) {
          $total = $result[0]['Total'];
        }
        // Postgres converts column names to lowercase
        if (isset($result[0]['total'])) {
          $total = $result[0]['total'];
        }

        $options->sql->type = 'select';
        $sql->fromJSON($options->sql);
        $sql->compile();
        $result = $connection->execute($sql->query, $sql->params);

        return array(
            'offset' => intval($options->sql->offset),
            'limit' => intval($options->sql->limit),
            'total' => intval($total),
            'page' => array(
                'offset' => array(
                    'first' => 0,
                    'prev' => intval($options->sql->offset - $options->sql->limit > 0 ? $options->sql->offset - $options->sql->limit : 0),
                    'next' => intval($options->sql->offset + $options->sql->limit < $total ? $options->sql->offset + $options->sql->limit : $options->sql->offset),
                    'last' => (ceil($total / $options->sql->limit)-1) * $options->sql->limit
                ),
                'current' => floor($options->sql->offset / $options->sql->limit)+1,
                'total' => ceil($total / $options->sql->limit)
            ),
            'data' => $result
        );
    }

    protected function parseOptions($options) {
        $props = array('values', 'wheres', 'orders');

        foreach ($props as $prop) {
            if (isset($options->sql->{$prop}) && is_array($options->sql->{$prop})) {
                $options->sql->{$prop} = array_filter($options->sql->{$prop}, array($this, 'filter'));
            }
        }

        if (isset($options->sql->wheres) && isset($options->sql->wheres->rules)) {
            if (isset($options->sql->wheres->conditional) && !$this->app->parseObject($options->sql->wheres->conditional)) {
                unset($options->sql->wheres);
            } else {
                $options->sql->wheres->rules = array_filter($options->sql->wheres->rules, array($this, 'filterRules'));

                if (empty($options->sql->wheres->rules)) {
                    unset($options->sql->wheres);
                }
            }
        }

        return $this->app->parseObject($options);
    }

    protected function filterRules($rule) {
        if (!isset($rule->rules)) return TRUE;
        if (isset($rule->conditional) && !$this->app->parseObject($rule->conditional)) return FALSE;
        $rule->rules = array_filter($rule->rules, array($this, 'filterRules'));
        return !empty($rule->rules);
    }

	protected function filter($val) {
		if (!isset($val->condition)) return TRUE;
		return $this->app->parseObject($val->condition);
	}
}
