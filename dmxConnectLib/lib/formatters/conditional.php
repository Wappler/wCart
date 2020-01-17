<?php

namespace lib\core;

function formatter_startsWith($val, $str) {
    return strpos(strval($val), strval($str)) === 0;
}

function formatter_endsWith($val, $str) {
    $str = strval($str);
    return substr(strval($val), -strlen($str)) == $str;
}

function formatter_contains($val, $str) {
    return strpos(strval($val), strval($str)) !== FALSE;
}

function formatter_between($val, $a, $b) {
    return $a <= $val && $val <= $b;
}
