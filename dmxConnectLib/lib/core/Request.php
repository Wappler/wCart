<?php

namespace lib\core;

class Request
{
    public $app;
    public $env;
    public $query;
    public $form;
    public $files;
    public $headers;
    public $cookies;
    public $method;
    public $ip;
    public $path;
    public $url;
    public $hostname;
    public $secure;
    public $xhr;

    public function __construct($app) {
        $this->app = $app;
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $this->getPost();
        $this->headers = $this->getHeaders();
        $this->cookies = $_COOKIE;

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['SCRIPT_NAME'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->hostname = $_SERVER['SERVER_NAME'];
        $this->secure = !empty($_SERVER['HTTPS']);
        $this->xhr = isset($this->headers['x-requested-with']) && strtolower($this->headers['x-requested-with']) == 'xmlhttprequest';
    }

    private function getHeaders() {
        $headers = array();

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $name = strtolower(str_replace('_', '-', substr($name, 5)));
                $headers[$name] = $value;
            }
        }

        return $headers;
    }

    private function getPost() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        $post = $_POST;

        if (stripos($contentType, 'application/json') === 0) {
            $post = json_decode(trim(file_get_contents('php://input')), TRUE);
        } else {
            // Extend post data with files data
            foreach ($_FILES as $field => $file) {
                if (is_string($file['name'])) {
                    $post[$field] = $file;
                    $post[$field]['isFile'] = TRUE;
                } else {
                    if (!isset($post[$field])) $files[$field] = array();
                    $this->parseField('error', $file['error'], $post[$field]);
                    $this->parseField('name', $file['name'], $post[$field]);
                    $this->parseField('size', $file['size'], $post[$field]);
                    $this->parseField('tmp_name', $file['tmp_name'], $post[$field]);
                    $this->parseField('type', $file['type'], $post[$field]);
                }
            }
        }

        return $post;
    }

    private function parseField($name, $src, &$dest) {
        foreach ($src as $key => $value) {
            if (!is_array($value)) {
                $dest[$key]['isFile'] = TRUE;
                $dest[$key][$name] = $value;
            } else {
                if (!isset($dest[$key])) $dest[$key] = array();
                $this->parseField($name, $src[$key], $dest[$key]);
            }
        }
    }
}
