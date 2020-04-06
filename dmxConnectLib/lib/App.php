<?php

namespace lib;

use \lib\core\Scope;
use \lib\core\Lexer;
use \lib\core\Parser;
use \lib\core\Request;
use \lib\core\Response;
use \lib\core\Session;
use \lib\core\FileSystem;

class App
{
    public $modules = array();

    public $WIN = FALSE;
    public $debug = FALSE;
    public $error = FALSE;
    public $data = array();
    public $meta = NULL;

    public $scope;
    public $lexer;
    public $parser;
    public $request;
    public $response;
    public $session;

    public function __construct() {
        $this->WIN = strtoupper(substr(PHP_OS, 0, 3));

		$this->scope = new Scope();
        $this->lexer = new Lexer();
        $this->parser = new Parser($this);
        $this->request = new Request($this);
        $this->response = new Response($this);
        $this->session = new Session();

        $this->scope->set(array(
            '$_ERROR' => $this->error,
            '$_SERVER' => $this->request->server,
            '$_GET' => $this->request->get,
            '$_POST' => $this->request->post,
            '$_HEADER' => $this->request->headers,
            '$_COOKIE' => $this->request->cookies,
            '$_SESSION' => $this->session
        ));
    }

    public function set($key, $value = NULL) {
        $this->scope->global->set($key, $value);
    }

    public function get($key, $defaultValue = NULL) {
        $value = $this->scope->global->get($key);
        return $value !== NULL ? $value : $defaultValue;
    }

    public function define($cfg) {
        if (is_string($cfg)) {
            $cfg = json_decode($cfg);

            if ($cfg === NULL) {
                Throw new \Exception('Error parsing the JSON in define');
            }
        }

        if (isset($cfg->settings)) $this->settings($cfg->settings);
        if (isset($cfg->meta)) $this->meta($cfg->meta);
        if (isset($cfg->vars)) $this->set($cfg->vars);
        if (isset($cfg->exec)) $this->exec($cfg->exec);
    }

    protected function settings($settings) {
        if (isset($settings->options)) {
            if (isset($settings->options->scriptTimeout)) {
                set_time_limit((int)$settings->options->scriptTimeout);
            }
        }
    }

    protected function meta($meta) {
        if (class_exists('\\lib\\validator\\Validator')) {
            $validator = \lib\validator\Validator::getInstance($this);
            $validator->parseMeta($meta);
        }

        $this->meta = $meta;
    }

    public function exec($actions, $internal = FALSE) {
        if (is_string($actions)) {
            $actions = json_decode($actions);

            if ($actions === NULL) {
                Throw new \Exception('Error parsing the JSON in exec');
            }
        }

        if (is_array($actions)) {
            foreach ($actions as $action) {
                $this->exec($action, $internal);
            }
        }

        $this->execSteps(isset($actions->steps) ? $actions->steps : $actions);

        if ($this->error !== FALSE) {
            if (isset($actions->catch)) {
                $this->scope->set('$_ERROR', $this->error->getMessage());
                $this->execSteps($actions->catch);
                $this->error = FALSE;
            } else {
                throw $this->error;
            }
        }

        if (!$internal) {
            $this->response->json($this->data);
        }
    }

    private function execSteps($steps) {
        if (is_string($steps)) {
            if (!preg_match("/\.php/", $steps)) {
                $steps .= ".php";
            }

			$path = realpath($this->get('ACTIONS_URL', BASE_URL . '/../dmxConnect/modules'));
            require(FileSystem::encode($path . DIRECTORY_SEPARATOR . $steps));
            $steps = json_decode($exports);
        }

        if (is_array($steps)) {
            foreach ($steps as $step) {
                $this->execSteps($step);
                if ($this->error !== FALSE) return;
            }
        }

        if (isset($steps->disabled)) {
            if ($steps->disabled) return;
        }

        if (is_callable($steps)) {
            try {
                $data = $steps();

                if (isset($steps->name) && isset($data)) {
                    $this->scope->set($steps->name, $data);

                    if (isset($steps->output) && $steps->output === TRUE) {
                        $this->data[$steps->name] = $data;
                    }
                }
            } catch(\Exception $err) {
                $this->error = $err;
                return;
            }
        }

        if (isset($steps->module) && isset($steps->action)) {
            if (!isset($this->modules[$steps->module])) {
                $className = '\\modules\\' . $steps->module;
                $this->modules[$steps->module] = new $className($this);
            }

            $module = $this->modules[$steps->module];

			try {
                if (method_exists($module, $steps->action)) {
				    $data = $module->{$steps->action}(isset($steps->options) ? clone $steps->options : NULL, isset($steps->name) ? $steps->name : NULL);
                } elseif (method_exists($module, '_'.$steps->action)) {
                    $data = $module->{'_'.$steps->action}(isset($steps->options) ? clone $steps->options : NULL, isset($steps->name) ? $steps->name : NULL);
                } else {
                    throw new \Exception("Action $step->action doesn't exist in $module", 1);
                }
			} catch (\Exception $err) {
				$this->error = $err;
				return;
			}

			if (isset($steps->name) && (isset($data) || is_null($data))) {
				$this->scope->set($steps->name, $data);

				if (isset($steps->output) && $steps->output === TRUE) {
					$this->data[$steps->name] = $data;
				}
			}
        }
    }

	public function parse($value, Scope $scope = NULL) {
		return $this->parseObject($value, $scope);
	}

    public function parseObject($value, Scope $scope = NULL) {
        if ($value === NULL) {
            return NULL;
        }

        if (is_object($value)) {
            $value = clone $value;
            foreach ($value as $key => $val) {
                $value->$key = $this->parseObject($val, $scope);
            }
        }

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = $this->parseObject($val, $scope);
            }
        }

        if (is_string($value)) {
            if (substr($value, 0, 2) == '{{' && substr($value, -2) == '}}') {
                $expression = substr($value, 2, -2);

                if (strpos($expression, '{{') === FALSE) {
                    return $this->parser->parse($expression, $scope);
                }
            }

            return $this->parseTemplate($value, $scope);
        }

        return $value;
    }

    public function parseTemplate($value, Scope $scope = NULL) {
        if (strpos($value, '{{') === FALSE) {
            return $value;
        }

        $self = $this;

        return preg_replace_callback('/\{\{(.*?)\}\}/', function($matches) use ($self, $scope) {
            $value = $self->parser->parse($matches[1], $scope);

            if ($value === NULL) {
                return '';
            }

            if (!is_string($value)) {
                return json_encode($value);
            }

            return $value;
        }, $value);
    }
}
