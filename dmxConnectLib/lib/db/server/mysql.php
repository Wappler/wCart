<?php

namespace lib\db\server;

class mysql
{
	public function __construct() {}

	public function likeFormat($format) {
		switch ($format) {
			case 'starts with'     : return "{column} LIKE CONCAT({value}, '%') ESCAPE '!'";
			case 'not starts with' : return "{column} NOT LIKE CONCAT({value}, '%') ESCAPE '!'";
			case 'ends with'       : return "{column} LIKE CONCAT('%', {value}) ESCAPE '!'";
			case 'not ends with'   : return "{column} NOT LIKE CONCAT('%', {value}) ESCAPE '!'";
			case 'contains'        : return "{column} LIKE CONCAT('%', {value}, '%') ESCAPE '!'";
			case 'not contains'    : return "{column} NOT LIKE CONCAT('%', {value}, '%') ESCAPE '!'";
		}

		throw new \Exception('Invalid format for LIKE expression.');
	}

	public function escapeLike($str) {
		return preg_replace('/[!%_]/', '!$0', $str);
	}

	public function quoteIdentifier($str) {
		return '`' . $str . '`';
	}

	public function concatExpression() {
		return 'CONCAT(' . implode(', ', func_get_args()) . ')';
	}

	public function dateTimeFormatString() {
		return 'Y-m-d H:i:s';
	}

	public function dateTimeTzFormatString() {
		return 'Y-m-d H:i:s';
	}

	public function supportPaging() {
		return TRUE;
	}

	public function limitQuery($query, $limit, $offset = 0) {
		if ($limit > 0) {
			$query .= ' LIMIT ' . $limit;
		}

		if ($offset > 0) {
			$query .= ' OFFSET ' . $offset;
		}

		return $query;
	}
}
