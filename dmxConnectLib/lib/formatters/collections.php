<?php

namespace lib\core;

if (!function_exists("array_column")) {
    function array_column($array, $column_name) {
        return array_map(function($element) use ($column_name) {
            return $element[$column_name];
        }, $array);
    }
}

function formatter_join($val, $chr, $prop = NULL) {
    if (!is_array($val)) return '';
    return implode(strval($chr), $prop != NULL ? array_column($val, strval($prop)) : $val);
}

function formatter_top($val, $count) {
    if (!is_array($val)) return array($val);
    return array_slice($val, 0, intval($count));
}

function formatter_last($val, $count) {
    if (!is_array($val)) return array($val);
    return array_slice($val, -intval($count));
}

function formatter_where($val, $prop, $operator, $value) {
    if (!is_array($val)) return array($val);
    return array_filter($val, function($o) use ($prop, $operator, $value) {
        $o = (array)$o;
        $v = $o[$prop];

        switch ($operator) {
            case 'startsWith':
                return strpos(strval($v), strval($value)) === 0;
            case 'endsWith':
                $value = strval($value);
                return substr(strval($v), -strlen($value)) == $value;
            case 'contains':
                return strpos(strval($v), strval($value)) !== FALSE;
            case '===':
                return $v === $value;
            case '==':
                return $v == $value;
            case '!==':
                return $v !== $value;
            case '!=':
                return $v != $value;
            case '<':
                return $v < $value;
            case '<=':
                return $v <= $value;
            case '>':
                return $v > $value;
            case '>=':
                return $v >= $value;
        }

        return TRUE;
    });
}

function formatter_unique($val, $prop = NULL) {
    if (!is_array($val)) return array($val);
    return array_unique($prop != NULL ? array_column($val, strval($prop)) : $val);
}

function formatter_groupBy($val, $prop) {
    if (!is_array($val)) return NULL;
    $groups = array();
    foreach ($val as $item) {
        $key = strval($item[$prop]);

        if (!array_key_exists($key, $groups)) {
            $groups[$key] = array();
        }

        $groups[$key][] = $item;
    }
    return (object)$groups;
}

function formatter_sort($val, $prop = NULL) {
    if (!is_array($val)) return $val;
    if ($prop != NULL) {
        return usort($val, function($a, $b) use ($prop) {
            if ($a[$prop] == $b[$prop]) return 0;
            return ($a[$prop] < $b[$prop]) ? -1 : 1;
        });
    }
    return sort($val);
}

function formatter_randomize($val) {
    if (!is_array($val)) return $val;
    shuffle($val);
    return $val;
}

function formatter_reverse($val) {
    if (!is_array($val)) return $val;
    return array_reverse($val);
}

function formatter_count($val) {
    if (!is_array($val)) return 0;
    return count($val);
}

function formatter_min($val, $prop) {
    if (!is_array($val) || count($val) === 0) return NULL;
    return min($prop != NULL ? array_column($val, strval($prop)) : $val);
}

function formatter_max($val, $prop) {
    if (!is_array($val) || count($val) === 0) return NULL;
    return max($prop != NULL ? array_column($val, strval($prop)) : $val);
}

function formatter_sum($val, $prop) {
    if (!is_array($val) || count($val) === 0) return NULL;
    $val = array_filter($prop != NULL ? array_column($val, strval($prop)) : $val, function($var) {
        return is_numeric($var);
    });
    return array_sum($val);
}

function formatter_avg($val, $prop) {
    if (!is_array($val) || count($val) === 0) return NULL;
    $val = array_filter($prop != NULL ? array_column($val, strval($prop)) : $val, function($var) {
        return is_numeric($var);
    });
    return array_sum($val) / count($val);
}

function formatter_keys($val) {
    if (!is_array($val) && !is_object($val)) return array();
    return array_keys((array)$val);
}

function formatter_values($val) {
    if (!is_array($val) && !is_object($val)) return array();
    return array_values((array)$val);
}
