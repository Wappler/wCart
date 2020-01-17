<?php

namespace lib\core;

class Scope
{
    public $global = NULL;
    public $parent = NULL;
    public $data = array();
    
    public function __construct(Scope $parent = NULL, $data = NULL) {
        if ($parent === NULL) {
            $this->global = $this;
        } else {
            $this->global = $parent->global;
            $this->parent = $parent;
        }
        
        if ($data !== NULL) {
            $this->data = (array)$data;
        }
    }
    
    public function set($key, $value = NULL) {
        if (is_array($key)) {
            $key = (object)$key;
        }
        
        if (is_object($key)) {
            foreach ($key as $name => $value) {
                $this->set($name, $value);
            }
        } else {
            $this->data[$key] = $value;
        }
    }
    
    public function get($key) {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        
        if ($this->parent !== NULL) {
            return $this->parent->get($key);
        }
        
        return NULL;
    }
    
    public function has($key) {
        if (isset($this->data[$key])) {
            return TRUE;
        }
        
        if ($this->parent !== NULL) {
            return $this->parent->has($key);
        }
        
        return FALSE;
    }
    
    public function remove($key) {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }
    }
}