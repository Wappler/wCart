<?php

namespace modules;

use \lib\core\Module;
use \lib\db\Connection;
use \lib\db\SqlBuilder;

class dbupdater extends Module
{
	public function insert($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'table');

		$options = $this->parseOptions($options);

        $options->sql->type = 'insert';

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
		$sql->compile();

		if (isset($options->test)) {
			return (object)array(
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params, FALSE, $sql->table);
	}

	public function update($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'table');

		$options = $this->parseOptions($options);

        $options->sql->type = 'update';

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
		$sql->compile();

		if (isset($options->test)) {
			return (object)array(
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params);
	}

	public function delete($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'table');

		$options = $this->parseOptions($options);

        $options->sql->type = 'delete';

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

        $sql = new SqlBuilder($this->app, $connection);

        $sql->fromJSON($options->sql);
		$sql->compile();

		if (isset($options->test)) {
			return (object)array(
				'query' => $sql->query,
				'params' => $sql->params
			);
		}

        return $connection->execute($sql->query, $sql->params);
	}

	public function custom($options) {
		option_require($options, 'connection');
		option_require($options, 'sql');
		option_require($options->sql, 'query');
		option_require($options->sql, 'params');

		$options = $this->parseOptions($options);

		$connection = $this->app->scope->get($options->connection);

		if ($connection === NULL) {
			throw new \Exception('Connection "' . $options->connection . '" not found.');
		}

		$query = $options->sql->query;
		$params = array();

        $query = preg_replace_callback('/((?<=[^:])[:@]\w+|\?)/', function($matches) use (&$params, $options) {
            $match = $matches[0];

            if ($match == '?') {
                $params[] = $options->sql->params[count($params)];
            } else {
                $columns = array_column($options->sql->params, 'name');
                $key = array_search($match, $columns);
                $params[] = $options->sql->params[$key];
            }

            return '?';
        }, $query);

        if (isset($options->test)) {
			return (object)array(
				'query' => $query,
				'params' => $params
			);
		}

		return $connection->execute($query, $params);
	}

	public function execute($options) {
		option_require($options, 'connection');
		option_require($options, 'query');
		option_default($options, 'params', array());

		$options = $this->app->parseObject($options);

        $connection = $this->app->scope->get($options->connection);

        if ($connection === NULL) {
            throw new \Exception('Connection "' . $options->connection . '" not found.');
        }

		return $connection->execute($options->query, $options->params);
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
