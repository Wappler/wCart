<?php

namespace lib\core;

class Session
{
    public function __construct() {
		if (PHP_SAPI != 'cli') {
        	session_start();
		}
    }
    
    public function __set($name, $value) {
        $this->set($name, $value);
    }
    
    public function __get($name) {
        return $this->get($name);
    }
    
    public function __isset($name) {
        return $this->has($name);
    }
    
    public function __unset($name) {
        $this->remove($name);
    }
    
    public function items() {
        return $_SESSION;
    }
    
    public function keys() {
        return array_keys($_SESSION);
    }
    
    public function values() {
        return array_values($_SESSION);
    }
    
    public function has($name) {
        return isset($_SESSION[$name]);
    }
    
    public function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : NULL;
    }
    
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }
    
    public function remove($name) {
        unset($_SESSION[$name]);
    }
}