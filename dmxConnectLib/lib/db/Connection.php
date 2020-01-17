<?php

namespace lib\db;

use \PDO;
use \lib\App;

class Connection
{
	public $app;
	public $server;
	public $pdo;

	public function __construct(App $app, $options) {
		$this->app = $app;

		if (!isset($options->connectionString)) {
			throw new \Exception('Connection String is Required');
		}

		$className = '\\lib\\db\\server\\' . $options->server;
		$this->server = new $className();

		$dsn = $options->connectionString;
		$user = '';
		$password = '';
		$preps = FALSE;
		$sslca = '';
		$sslverify = FALSE;
		$pdo_options = NULL;

		if (preg_match("/user=([^;]*)/i", $dsn, $match)) {
			$user = $match[1];
		}

		if (preg_match("/password=([^;]*)/i", $dsn, $match)) {
			$password = $match[1];
		}

		if (!preg_match('/^pgsql:/', $dsn)) {
			$dsn = preg_replace("/(user|password)=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/preps=([^;]*)/i', $dsn, $match)) {
			$preps = $match[1] === 'true' ? TRUE : FALSE;
			$dsn = preg_replace("/preps=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/sslca=([^;]*)/i', $dsn, $match)) {
			$sslca = $match[1];
			$dsn = preg_replace("/sslca=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/sslverify=([^;]*)/i', $dsn, $match)) {
			$sslverify = $match[1] === 'true' ? TRUE : FALSE;
			$dsn = preg_replace("/sslverify=[^;]*;?/i", '', $dsn);
		}

		if (preg_match('/^mysql:/', $dsn)) {
			$pdo_options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				PDO::ATTR_EMULATE_PREPARES => $preps,
				PDO::ATTR_STRINGIFY_FETCHES => FALSE
			);

			if (version_compare(PHP_VERSION, '5.3.7', '>=') && $sslca) {
				$pdo_options[PDO::MYSQL_ATTR_SSL_CA] = $sslca;

				if (version_compare(PHP_VERSION, '7.0.18', '>=')) {
					$pdo_options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = $sslverify;
				}
			}
		}

		$this->pdo = new PDO($dsn, $user, $password, $pdo_options);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function execute($query, array $params, $returnRecords = TRUE, $table = '') {
		$statement = $this->pdo->prepare($query);

		foreach ($params as $key => $param) {
			$param = $this->app->parseObject($param);

			if (isset($param->type) && isset($param->value) && is_string($param->value) && strtolower($param->value) == 'now') {
				switch (strtolower($param->type)) {
					case 'date':
					$param->value = date('Y-m-d');
					break;
					case 'time':
					$param->value = date('H:i:s');
					break;
					case 'datetime':
					$param->value = date('Y-m-d H:i:s');
					break;
				}
			}

			if (isset($param->whereType) && $param->whereType == 'Like') {
				$param->value = $this->server->escapeLike(strval($param->value));
			} elseif (isset($param->operation) && $param->operation == 'LIKE') {
				$param->value = $this->server->escapeLike(strval($param->value));
			}

			$statement->bindParam($key + 1, $param->value, $this->getParamType($param->value));
		}

		$statement->execute();

		if ($returnRecords && $statement->columnCount() > 0) {
			return $statement->fetchAll(PDO::FETCH_ASSOC);
		}

		$identity = NULL;

		try {
			if (stristr($query, 'insert')) {
				if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) == 'pgsql') {
					$identity = $this->pdo->lastInsertId($table.'_id_seq');
				} else {
					$identity = $this->pdo->lastInsertId();
				}
			}
		} catch(\Exception $err) {
			// Ignore the error
		}

		return (object)array(
			'identity' => $identity,
			'affected' => $statement->rowCount()
		);
	}

	private function getParamType($value) {
		if ($value === NULL) {
			return PDO::PARAM_NULL;
		}
		elseif (is_bool($value)) {
			return PDO::PARAM_BOOL;
		}
		elseif (is_int($value)) {
			return PDO::PARAM_INT;
		}

		return PDO::PARAM_STR;
	}
}
