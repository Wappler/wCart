<?php

namespace lib\core;

function formatter_floor($val) {
    return floor(floatval($val));
}

function formatter_ceil($val) {
    return ceil(floatval($val));
}

function formatter_round($val) {
    return round(floatval($val));
}

function formatter_abs($val) {
    return abs(floatval($val));
}

function formatter_padNumber($val, $digids) {
    $num = floatval($val);
    $sign = $num < 0 ? '-' : '';
    $num = strval(abs($num));
    return $sign . str_pad($num, intval($digids), '0', STR_PAD_LEFT);
}

function formatter_formatNumber($val, $decimals = NULL, $separator = '.', $delimiter = '') {
    if (!is_numeric($val)) return '';
    return number_format(floatval($val), intval($decimals), strval($separator), strval($delimiter));
}

function formatter_hex($val) {
    return hexdec(strval($val));
}

function formatter_currency($val, $unit = '$', $separator = '.', $delimiter = ',', $precision = 2) {
    if (!is_numeric($val)) return '';
    $num = floatval($val);
    $sign = $num < 0 ? '-' : '';
    return $sign . $unit . number_format(abs($num), intval($precision), strval($separator), strval($delimiter));
}

function formatter_formatSize($val, $decimals = 2, $binary = FALSE) {
    if (!is_numeric($val)) return '';
    $bytes = intval($val);
    $decimals = intval($decimals);
    $binary = boolval($binary);

    $base = $binary ? 1024 : 1000;
    $suff = $binary ? array('KiB', 'MiB', 'GiB', 'TiB') : array('kB', 'MB', 'GB', 'TB');

    for ($i = 3; $i >= 0; $i--) {
        $n = pow($base, $i + 1);
        if ($bytes >= $n) {
            return number_format($bytes / $n, $decimals) . $suff[$i];
        }
    }

    return $bytes . 'B';
}
