<?php

namespace lib\auth;

use lib\App;
use lib\db\SqlBuilder;

class DatabaseProvider
{
	protected $app;
	protected $options;
	protected $connection;

	public function __construct(App $app, $options) {
		option_require($options, 'connection');

		$this->app = $app;
		$this->options = $options;
		$this->connection = $this->app->scope->get($this->options->connection);
	}

	public function validate($username, $password) {
		$sql = new SqlBuilder($this->app, $this->connection);

		$user = $this->options->users;

		$sql->select($user->identity, $user->username, $user->password);
		$sql->from($user->table);
		$sql->where($user->username, '=', $username);
		$sql->where($user->password, '=', $password);
		$sql->compile();

		$result = $this->connection->execute($sql->query, $sql->params);

		foreach ($result as $data) {
			// we check username and password again in case database is not case-sensitive
			if ($data[$user->username] == $username && $data[$user->password] == $password) {
				return $data[$user->identity];
			}
		}

		return FALSE;
	}

	public function permissions($identity, $permissions) {
		foreach ($permissions as $permission) {
			if (!isset($this->options->permissions->$permission)) {
				return FALSE;
			}

			$perm = $this->options->permissions->$permission;

			$table = isset($perm->table) ? $perm->table : $this->options->users->table;
			$ident = isset($perm->identity) ? $perm->identity : $this->options->users->identity;

			$sql = new SqlBuilder($this->app, $this->connection);

			$sql->select($ident);
			$sql->from($table);
			$sql->where($ident, '=', $identity);

			foreach ($perm->conditions as $condition) {
				$sql->where($condition->column, $condition->operator, $condition->value);
			}

			$sql->compile();

			if (count($this->connection->execute($sql->query, $sql->params)) == 0) {
				return FALSE;
			}
		}

		return TRUE;
	}
}
