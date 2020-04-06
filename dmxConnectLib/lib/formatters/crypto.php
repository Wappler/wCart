<?php

namespace lib\core;

function formatter_md5($val, $salt = '') {
    return md5($val . $salt);
}

function formatter_sha1($val, $salt = '') {
    return sha1($val . $salt);
}

function formatter_sha256($val, $salt = '') {
    return hash('sha256', $val . $salt);
}

function formatter_sha512($val, $salt = '') {
    return hash('sha512', $val . $salt);
}

function formatter_encodeBase64($val) {
    return base64_encode($val);
}

function formatter_decodeBase64($val) {
    return base64_decode($val);
}

function formatter_encrypt($val, $password) {
    $key = hash('sha256', $password, TRUE);
    $iv = openssl_random_pseudo_bytes(16);
    if (($l = (strlen($val) & 15)) > 0) { $val .= str_repeat(chr(0), 16 - $l); }
    return base64_encode($iv . openssl_encrypt($val, 'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv));
}

function formatter_decrypt($val, $password) {
    $key = hash('sha256', $password, TRUE);
    $val = base64_decode($val);
    return rtrim(openssl_decrypt(substr($val, 16), 'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, substr($val, 0, 16)), "\0");
}
