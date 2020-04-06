<?php

namespace lib\core;

if (!function_exists('boolval')) {
    function boolval($val) {
        return (bool) $val;
    }
}

function formatter_lowercase($val) {
    if ($val == NULL) return NULL;
    return strtolower(strval($val));
}

function formatter_uppercase($val) {
    if ($val == NULL) return NULL;
    return strtoupper(strval($val));
}

function formatter_camelize($val) {
    if ($val == NULL) return NULL;
    $val = strval($val);
    $val = trim($val);
    $val = preg_replace_callback('/(\-|_|\s)+(.)?/', function($match) {
        return (isset($match[2]) ? strtoupper($match[2]) : '');
    }, $val);
    return $val;
}

function formatter_capitalize($val) {
    if ($val == NULL) return NULL;
    return ucfirst(strval($val));
}

function formatter_dasherize($val) {
    if ($val == NULL) return NULL;
    $val = strval($val);
    $val = preg_replace('/[_\s]+/', '-', $val);
    $val = preg_replace('/([A-Z])/', '-$1', $val);
    $val = preg_replace('/-+/', '-', $val);
    return strtolower($val);
}

function formatter_humanize($val) {
    if ($val == NULL) return NULL;
    $val = strval($val);
    $val = trim($val);
    $val = preg_replace('/([a-z\d])([A-Z]+)/', '$1_$2', $val);
    $val = preg_replace('/[-\s]+/', '_', $val);
    $val = strtolower($val);
    $val = preg_replace('/_id$/', '', $val);
    $val = str_replace('_', ' ', $val);
    $val = trim($val);
    return ucfirst($val);
}

function formatter_slugify($val) {
    if ($val == NULL) return NULL;
    $val = strval($val);
    $val = preg_replace('/[^\w\s]/', '', $val);
    $val = strtolower($val);
    $val = preg_replace('/[_\s]+/', '-', $val);
    $val = preg_replace('/-+/', '-', $val);
    $val = preg_replace('/^-/', '', $val);
    return $val;
}

function formatter_underscore($val) {
    if ($val == NULL) return NULL;
    $val = strval($val);
    $val = trim($val);
    $val = preg_replace('/([a-z\d])([A-Z]+)/', '$1_$2', $val);
    $val = preg_replace('/[-\s]+/', '_', $val);
    return strtolower($val);
}

function formatter_titlecase($val) {
    return ucwords(strval($val));
}

function formatter_camelcase($val) {
    if ($val == NULL) return NULL;
    $val = strval($val);
    $val = strtolower($val);
    $val = preg_replace_callback('/\s+(\S)/', function($match) {
        return strtoupper($match[1]);
    }, $val);
    return $val;
}

function formatter_replace($val, $search, $replace) {
    if ($val == NULL) return NULL;
    return str_replace(strval($search), strval($replace), strval($val));
}

function formatter_trim($val) {
    if ($val == NULL) return NULL;
    return trim(strval($val));
}

function formatter_split($val, $delimiter) {
    return explode(strval($delimiter), strval($val));
}

function formatter_pad($val, $length, $chr = ' ', $pos = 'left') {
    $pad_type = STR_PAD_LEFT;
    if ($pos == 'right') $pad_type = STR_PAD_RIGHT;
    if ($pos == 'center') $pad_type = STR_PAD_BOTH;
    return str_pad(strval($val), intval($length), strval($chr), $pad_type);
}

function formatter_repeat($val, $num) {
    return str_repeat(strval($val), intval($num));
}

function formatter_substr($val, $start, $length = NULL) {
    return substr(strval($val), intval($start), $length == NULL ? strlen($val) : intval($length));
}

function formatter_trunc($val, $num, $useWordBoundry = FALSE, $chr = '…') {
    $val = strval($val);
    $num = intval($num);
    $useWordBoundry = boolval($useWordBoundry);
    $chr = strval($chr);

    if (strlen($val) > $num) {
        $val = substr($val, 0, $num - 1);

        if ($useWordBoundry && strpos($val, ' ') !== FALSE) {
            $val = substr($val, 0, strrpos($val, ' '));
        }

        $val .= $chr;
    }

    return $val;
}

function formatter_stripTags($val) {
    return strip_tags(strval($val));
}

function formatter_wordCount($val) {
    return str_word_count(strval($val));
}
