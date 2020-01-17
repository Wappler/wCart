<?php
if (version_compare(PHP_VERSION, '5.2.0', '<')) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
    exit('PHP 5.2.0 or higher is required, you are runner version ' . PHP_VERSION . '!');
}

define('E_FATAL', E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

error_reporting(0);
ini_set('default_charset','utf-8');
ini_set('display_errors', 0);
set_error_handler('error_handler');
set_exception_handler('exception_handler');
register_shutdown_function('fatal_handler');

class MyError
{
	public $code = 0;
	public $message = '';
	public $file = '';
	public $line = 0;
	public $trace = NULL;

	static public $warnings = array();

	static public function register($code, $message, $file, $line, $trace = NULL, $fatal = FALSE) {
		$error = new MyError($code, $message, $file, $line, $trace);

		if ($fatal || $code & E_FATAL) {
			header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
			header('Content-type: application/json; charset=utf-8');
			exit($error);
		}

		array_push(self::$warnings, $error);
	}

	public function __construct($code, $message, $file, $line, $trace = NULL) {
		$this->code = $code;
		$this->message = $message;
		$this->file = $file;
		$this->line = $line;
		$this->trace = $trace;
	}

	public function __toString() {
		global $dmxConnectionDebug;

		if ($dmxConnectionDebug === TRUE) {
			$obj = clone $this;
			$obj->warnings = MyError::$warnings;
			return json_encode($obj);
		}

		return $this->message;
	}
}

function error_handler($errNo, $errStr, $errFile, $errLine) {
	MyError::register($errNo, $errStr, $errFile, $errLine);
	return TRUE;
}

function exception_handler($e) {
	MyError::register($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTrace() , TRUE);
}

function fatal_handler() {
	$error = error_get_last();
	if($error && ($error['type'] & E_FATAL)) {
		MyError::register($error["type"], $error["message"], $error["file"], $error["line"]);
	}
}

if (!empty($_REQUEST['connectionString'])) {
	$dsn = $_REQUEST['connectionString'];
} else {
	header($_SERVER["SERVER_PROTOCOL"] . ' 400 Bad Request');
	exit('connection string is required!');
}

if (empty($_REQUEST['schema'])) {
	header($_SERVER["SERVER_PROTOCOL"] . ' 400 Bad Request');
	exit('schema is required!');
}

try {
	$driver = explode(':', $dsn, 2);
	$driver = $driver[0];
	preg_match("/user=([^;]*)/i", $dsn, $match);
	$user = $match[1];
	preg_match("/password=([^;]*)/i", $dsn, $match);
	$password = $match[1];
	preg_match("/(dbname|database)=([^;]*)/i", $dsn, $match);
	$database = $match[2];
	preg_match("/sslca=([^;]*)/i", $dsn, $match);
	$sslca = $match[1];
	preg_match("/sslverify=([^;]*)/i", $dsn, $match);
	$sslverify = $match[1] === 'true' ? TRUE : FALSE;
} catch (Exception $e) {
	header($_SERVER["SERVER_PROTOCOL"] . ' 400 Bad Request');
	exit('invalid connection string!');
}

if ($driver != 'pgsql') {
	$dsn = preg_replace("/(user|password)=[^;]*;?/i", '', $dsn);
}

$dsn = preg_replace("/(sslca|sslverify)=[^;]*;?/i", '', $dsn);

$data = array();

foreach ($_REQUEST['schema'] as $schema) {
	switch ($schema) {
		case 'tables':
			$data['allTables'] = getAllTables();
			break;

		case 'views':
			$data['allViews'] = getAllViews();
			break;

		case 'procs':
			$data['allProcs'] = getAllProcs();
			break;

		case 'columns':
			$data['allColumns'] = getAllColumns();
			break;

		case 'db':
			$data['db'] = getDb();
			break;

		case 'table':
			$data['tables'] = array();
			foreach ($_REQUEST['table'] as $table) {
				$data['tables'][$table] = getTable($table);
			}
			break;

		case 'proc':
			$data['procs'] = array();
			foreach ($_REQUEST['proc'] as $proc) {
				$data['procs'][$proc] = getProc($proc);
			}
			break;

		default:
			break;
	}
}

print(json_encode($data));

function getAllTables() {
	global $driver, $database;

	$tables = array();

	if ($driver == 'sqlite') {
		$results = getResult("SELECT name FROM sqlite_master WHERE type = 'table'");

		foreach ($results as $result) {
			$tables[] = $result['name'];
		}
	} else {
		if ($driver == 'mysql') {
			$results = getResult("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_TYPE = 'BASE TABLE'");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT TABLE_NAME AS \"TABLE_NAME\" FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'public' AND TABLE_CATALOG = '$database' AND TABLE_TYPE = 'BASE TABLE'");
		} else {
			$results = getResult("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG = '$database' AND TABLE_TYPE = 'BASE TABLE'");
		}

		foreach ($results as $result) {
			$tables[] = $result['TABLE_NAME'];
		}
	}

	return $tables;
}

function getAllViews() {
	global $driver, $database;

	$views = array();

	if ($driver == 'sqlite') {
		$results = getResult("SELECT name FROM sqlite_master WHERE type = 'view'");

		foreach ($results as $result) {
			$views[] = $result['name'];
		}
	} else {
		if ($driver == 'mysql') {
			$results = getResult("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_TYPE = 'VIEW'");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT TABLE_NAME AS \"TABLE_NAME\" FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'public' AND TABLE_CATALOG = '$database' AND TABLE_TYPE = 'VIEW'");
		} else {
			$results = getResult("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG = '$database' AND TABLE_TYPE = 'VIEW'");
		}

		foreach ($results as $result) {
			$views[] = $result['TABLE_NAME'];
		}
	}

	return $views;
}

function getAllProcs() {
	global $driver, $database;

	$procs = array();

	if ($driver == 'sqlite') {
		// not supported
	} else {
		if ($driver == 'mysql') {
			$results = getResult("SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '$database' AND ROUTINE_TYPE = 'PROCEDURE'");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT ROUTINE_NAME AS \"ROUTINE_NAME\" FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_CATALOG = '$database' AND ROUTINE_TYPE = 'PROCEDURE'");
		} else {
			$results = getResult("SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_CATALOG = '$database' AND ROUTINE_TYPE = 'PROCEDURE'");
		}

		foreach ($results as $result) {
			$procs[] = $result['ROUTINE_NAME'];
		}
	}

	return $procs;
}

function getAllColumns() {
	global $driver, $database;

	$columns = array();

	if ($driver == 'sqlite') {
		// TODO
		// $results = getResult("SELECT * FROM sqlite_master WHERE type IN ('table', 'view')");
		// foreach $results = getResult("PRAGMA table_info('$table_name')");
	} else {
		if ($driver == 'mysql') {
			$results = getResult("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database'");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT TABLE_NAME AS \"TABLE_NAME\", COLUMN_NAME AS \"COLUMN_NAME\", DATA_TYPE AS \"DATA_TYPE\" FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_CATALOG = '$database'");
		} else {
			$results = getResult("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_CATALOG = '$database'");
		}

		foreach ($results as $result) {
			//$columns[$result['TABLE_NAME']][$result['COLUMN_NAME']] = $result['DATA_TYPE'];
			$columns[$result['TABLE_NAME']][] = $result['COLUMN_NAME'];
		}
	}

	return $columns;
}

function getDb() {
	global $driver, $database;

	$db = array(
		'tables' => array(),
		'views' => array(),
		'procs' => array()
	);

	if ($driver == 'sqlite') {
		$results = getResult("SELECT * FROM sqlite_master WHERE type IN ('table', 'view')");

		foreach ($results as $result) {
			$db[$result['type'].'s'][] = $result['name'];
		}
	} else {
		if ($driver == 'mysql') {
			$results = getResult("SELECT TABLE_NAME, TABLE_TYPE FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_TYPE IN ('BASE TABLE', 'VIEW')");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT TABLE_NAME AS \"TABLE_NAME\", TABLE_TYPE AS \"TABLE_TYPE\" FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'public' AND TABLE_CATALOG = '$database' AND TABLE_TYPE IN ('BASE TABLE', 'VIEW')");
		} else {
			$results = getResult("SELECT TABLE_NAME, TABLE_TYPE FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_CATALOG = '$database' AND TABLE_TYPE IN ('BASE TABLE', 'VIEW')");
		}

		foreach ($results as $result) {
			$db[$result['TABLE_TYPE'] == 'VIEW' ? 'views' : 'tables'][] = $result['TABLE_NAME'];
		}

		if ($driver == 'mysql') {
			$results = getResult("SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '$database' AND ROUTINE_TYPE = 'PROCEDURE'");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT ROUTINE_NAME AS \"ROUTINE_NAME\" FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_CATALOG = '$database' AND ROUTINE_TYPE = 'PROCEDURE'");
		} else {
			$results = getResult("SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_CATALOG = '$database' AND ROUTINE_TYPE = 'PROCEDURE'");
		}

		foreach ($results as $result) {
			$db['procs'] = $result['ROUTINE_NAME'];
		}
	}

	return $db;
}

function getTable($table_name) {
	global $driver, $database;

	$table = array();
	$table['columns'] = array();
	//$table['keys'] = array();

	if ($driver == 'sqlite') {
		$results = getResult("PRAGMA table_info('$table_name')");

		foreach ($results as $result) {
			$column = $result['name'];

			$table['columns'][$column] = array();

			preg_match("/([^(]*)(\((\d+)\))?/i", $result['type'], $match);

			$table['columns'][$column]['type'] = $match[1];

			if ($match[3]) {
				$table['columns'][$column]['size'] = (int)$match[3];
			}

			if ($result['notnull'] == '0') {
				$table['columns'][$column]['nullable'] = TRUE;
			}

			if ($result['dflt_value'] != NULL) {
				$table['columns'][$column]['defaultValue'] = $result['dflt_value'];
			}

			if ($result['pk'] == '1') {
				$table['columns'][$column]['primary'] = TRUE;
			}
		}
	} else {
		if ($driver == 'mysql') {
			$results = getResult("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table_name' ORDER BY TABLE_NAME, ORDINAL_POSITION");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT COLUMN_NAME AS \"COLUMN_NAME\", DATA_TYPE AS \"DATA_TYPE\", CHARACTER_MAXIMUM_LENGTH AS \"CHARACTER_MAXIMUM_LENGTH\", IS_NULLABLE AS \"IS_NULLABLE\", COLUMN_DEFAULT AS \"COLUMN_DEFAULT\" FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_CATALOG = '$database' AND TABLE_NAME = '$table_name'  ORDER BY TABLE_NAME, ORDINAL_POSITION");
		} else {
			$results = getResult("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_CATALOG = '$database' AND TABLE_NAME = '$table_name' ORDER BY TABLE_NAME, ORDINAL_POSITION");
		}

		foreach ($results as $result) {
			$column = $result['COLUMN_NAME'];

			$table['columns'][$column] = array();

			$table['columns'][$column]['type'] = $result['DATA_TYPE'];

			if ($result['CHARACTER_MAXIMUM_LENGTH']) {
				$table['columns'][$column]['size'] = (int)$result['CHARACTER_MAXIMUM_LENGTH'];
			}

			if ($result['IS_NULLABLE'] == 'YES') {
				$table['columns'][$column]['nullable'] = TRUE;
			}

			if ($result['COLUMN_DEFAULT'] != NULL) {
				$table['columns'][$column]['defaultValue'] = $result['COLUMN_DEFAULT'];
			}

			if ($driver == 'mysql') {
				if ($result['COLUMN_KEY'] == 'PRI') {
					$table['columns'][$column]['primary'] = TRUE;
				}
			}
		}
	}

	return $table;
}

function getProc($proc_name) {
	global $driver, $database;

	$proc = array();
	$proc['parameters'] = array();

	if ($driver == 'sqlite') {
		// not supported
	} else {
		if ($driver == 'mysql') {
			$results = getResult("SELECT * FROM INFORMATION_SCHEMA.PARAMETERS WHERE SPECIFIC_SCHEMA = '$database' AND SPECIFIC_NAME = '$proc_name'");
		} elseif ($driver == 'pgsql') {
			$results = getResult("SELECT PARAMETER_NAME AS \"PARAMETER_NAME\", PARAMETER_MODE AS \"PARAMETER_MODE\", PARAMETER_TYPE AS \"PARAMETER_TYPE\", DATA_TYPE AS \"DATA_TYPE\", CHARACTER_MAXIMUM_LENGTH AS \"CHARACTER_MAXIMUM_LENGTH\" FROM INFORMATION_SCHEMA.PARAMETERS WHERE SPECIFIC_CATALOG = '$database' AND SPECIFIC_NAME = '$proc_name'");
		} else {
			$results = getResult("SELECT * FROM INFORMATION_SCHEMA.PARAMETERS WHERE SPECIFIC_CATALOG = '$database' AND SPECIFIC_NAME = '$proc_name'");
		}

		foreach ($results as $result) {
			$param = $result['PARAMETER_NAME'];

			$proc['parameters'][$param]['direction'] = $driver == 'mysql' ? $result['PARAMETER_MODE'] : $result['PARAMETER_TYPE'];
			$proc['parameters'][$param]['type'] = $result['DATA_TYPE'];

			if ($result['CHARACTER_MAXIMUM_LENGTH']) {
				$proc['parameters'][$param]['size'] = (int)$result['CHARACTER_MAXIMUM_LENGTH'];
			}
		}
	}

	return $proc;
}

function getResult($sql) {
	global $driver, $dsn, $user, $password, $sslca, $sslverify;
	try {
		$pdo = new PDO($dsn, $user, $password);

		if ($driver == 'mysql') {
			if (version_compare(PHP_VERSION, '5.3.7', '>=') && $sslca) {
				$pdo->setAttribute(PDO::MYSQL_ATTR_SSL_CA, $sslca);

				if (version_compare(PHP_VERSION, '7.0.18', '>=')) {
					$pdo->setAttribute(PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT, $$sslverify);
				}
			}
		}

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$results = $pdo->query($sql);

		return $results->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error');
		exit($e->getMessage());
	}
}
?>