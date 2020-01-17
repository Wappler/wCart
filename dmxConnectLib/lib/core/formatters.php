<?php

namespace lib\core;

function formatter_default($val, $default) {
    return isset($val) && !empty($val)  ? $val : $default;
}

function formatter_then($val, $true, $false) {
    return $val ? $true : $false;
}

function formatter_toNumber($val) {
    return floatval($val);
}

function formatter_toString($val) {
    return strval($val);
}

function formatter_toJSON($val) {
    return json_encode($val);
}

function formatter_parseJSON($val) {
    return json_decode($val);
}
