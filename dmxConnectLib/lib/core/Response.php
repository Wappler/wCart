<?php

namespace lib\core;

class Response
{
    public static $statusText = array(
        // 1xx Informational
        100 => 'Continue',
        101 => 'Switching Protocols',
        // 2xx Success
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        // 3xx Redirection
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        // 4xx Client Error
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        // 5xx Server Error
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );

    public $app;
    public $status = 200;
    public $charset = 'utf-8';
    public $contentType = NULL;
    public $headers = array(
        "X-Generator" => "DMXzone Server Connect"
    );
    public $buffer = array();

    public function __construct($app) {
        $this->app = $app;
    }

    public function setCookie($name, $value, $options) {
        $cookie = rawurlencode($name) . '=' . rawurlencode($value);

        if (isset($options->expires)) {
            $sign = $options->expires < 0 ? '-' : '+';
            $expires = gmdate(DATE_COOKIE, strtotime($sign . abs($options->expires) . ' days'));
            $cookie .= ';expires=' . $expires;
        }

        if (isset($options->path)) {
            $cookie .= ';path=' . $options->path;
        }

        if (isset($options->domain)) {
            $cookie .= ';domain=' . $options->domain;
        }

        if (isset($options->httpOnly)) {
            $cookie .= ';HttpOnly';
        }

        $this->addHeader('Set-Cookie', $cookie);
    }

    public function clearCookie($name, $options) {
        if (!isset($options)) {
            $options = (object)array();
        }

        $options->expires = -1;

        $this->setCookie($name, '', $options);
    }

    public function clearBuffer() {
        $this->buffer = array();
        return $this;
    }

    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setContentType($contentType) {
        $this->contentType = $contentType;
        return $this;
    }

    public function setCharset($charset) {
        $this->charset = $charset;
        return $this;
    }

    public function flush() {
        foreach ($this->buffer as $buffer) {
            echo $buffer;
        }

        $this->buffer = array();
    }

    public function write($buffer) {
        $this->buffer[] = $buffer;
        return $this;
    }

    public function json($data) {

        $phpSapiName = substr(php_sapi_name(), 0, 3);
        $httpStatusMsg = isset(self::$statusText[$this->status]) ? self::$statusText[$this->status] : $this->status;
        if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
            header('Status: ' . $this->status . ' ' . $httpStatusMsg);
        } else {
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
            header($protocol . ' ' . $this->status . ' ' . $httpStatusMsg);
        }

        header('Content-Type: application/json; charset=' . $this->charset);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        $this->jsonToOutput($data);

        exit();
    }

    private function jsonToOutput($data) {
        if (is_array($data) || is_object($data)) {
			$first = true;
			$array = !is_object($data);
			if ($array && count($data) > 0) {
				$keys = array_keys($data);
				$last = count($data) - 1;
				if ($keys[0] === 0 && $keys[$last] === $last) {
					for ($i = 0; $i < $last; $i++) {
						if ($keys[$i] !== $i) {
							$array = false;
							break;
						}
					}
				} else {
					$array = false;
				}
			}
            echo ($array ? '[' : '{');
            foreach ($data as $key => $value) {
                if ($first) {
                    $first = false;
                } else {
                    echo ',';
                }
                if (!$array) echo '"' . $key . '":';
                $this->jsonToOutput($value);
            }
            echo ($array ? ']' : '}');
        } else {
            echo json_encode($data);
        }
    }

    public function error($errror) {
        throw new \Exception($error);
    }

    public function end($status = NULL, $buffer = NULL) {
        if ($status !== NULL) {
            if (is_int($status)) {
                $this->setStatus($status);
                $this->end(isset($buffer) ? $buffer : (isset(self::$statusText[$status]) ? self::$statusText[$status] : (string)$status));
            }

            if (is_string($status)) {
                $this->write($status);
            } else {
                $this->json($status);
            }
        }

        $phpSapiName = substr(php_sapi_name(), 0, 3);
        $httpStatusMsg = isset(self::$statusText[$this->status]) ? self::$statusText[$this->status] : $this->status;
        if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
            header('Status: ' . $this->status . ' ' . $httpStatusMsg);
        } else {
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
            header($protocol . ' ' . $this->status . ' ' . $httpStatusMsg);
        }

        header('Content-Type: ' . $this->contentType . '; charset=' . $this->charset);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        exit(implode($this->buffer));
    }
}
