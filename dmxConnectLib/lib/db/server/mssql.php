<?php

namespace lib\db\server;

class mssql
{
	public function __construct() {}
	
	public function likeFormat($format) {
		switch ($format) {
			case 'starts with'     : return "{column} LIKE ({value} + '%') ESCAPE '!'";
			case 'not starts with' : return "{column} NOT LIKE ({value} + '%') ESCAPE '!'";
			case 'ends with'       : return "{column} LIKE ('%' + {value}) ESCAPE '!'";
			case 'not ends with'   : return "{column} NOT LIKE ('%' + {value}) ESCAPE '!'";
			case 'contains'        : return "{column} LIKE ('%' + {value} + '%') ESCAPE '!'";
			case 'not contains'    : return "{column} NOT LIKE ('%' + {value} + '%') ESCAPE '!'";
		}
		
		throw new \Exception('Invalid format for LIKE expression.');
	}
	
	public function escapeLike($str) {
		return preg_replace('/[!%_]/', '!$0', $str);
	}
	
	public function quoteIdentifier($str) {
		return '[' . str_replace(']', ']]', $str) . ']';
	}
	
	public function concatExpression() {
		return '(' . implode(' + ', func_get_args()) . ')';
	}
	
	public function dateTimeFormatString() {
		return 'Y-m-d H:i:s.u';
	}
	
	public function dateTimeTzFormatString() {
		return 'Y-m-d H:i:s.u';
	}
	
	public function supportPaging() {
		return TRUE;
	}
	
	public function limitQuery($query, $limit, $offset = 0) {
		if ($offset > 0) {
			$pos = strpos($query, 'ORDER BY');
			$over = 'ORDER BY (SELECT 0)';
			
			if ($pos) {
				$over = substr($query, $pos);
			}
			
			$query = preg_replace('/\s+ORDER\s+BY(.*)/', '', $query);
			$query = preg_replace('/^SELECT\s+/', '', $query);

			$query = 'SELECT * FROM (SELECT ROW_NUMBER() OVER (' . $over . ') AS dmx_rownum, ' . $query . ' AS dmx_tbl WHERE dmx_rownum > ' . $offset;
			
			if ($limit > 0) {
				$query .= ' AND dmx_rownum <= ' . ($offset + $limit);
			}
		} elseif ($limit > 0) {
			$query = preg_replace('/^(SELECT\s+(DISTINCT\s+)?)/i', '$1TOP ' . $limit . ' ', $query);
		}
		
		return $query;
	}
}