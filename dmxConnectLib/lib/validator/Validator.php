<?php

namespace lib\validator;

class Validator extends \lib\core\Singleton
{
    public function parseMeta($meta) {
        $errors = NULL;

        foreach ($meta as $global => $entry) {
            if (strpos($global, '$_') === 0) {
                $this->validateFields($entry, $this->app->scope->data[$global], $errors);
            }
        }

        if (!is_null($errors)) {
            $this->app->response->end(400, $errors);
        }
    }

    public function validate($data) {
        $errors = NULL;

        foreach ($data as $item) {
            foreach ($item->rules as $rule => $props) {
                if (!$this->validateRule($rule, $item->value, $props)) {
                    if (!isset($errors)) $errors = (object)array();
                    if (isset($item->fieldName)) {
                        if (!isset($errors->form)) $errors->form = (object)array();
                        $errors->form->{$item->fieldName} = $this->getErrorMessage($rule, $props);
                    } else {
                        if (!isset($errors->data)) $errors->data = (object)array();
                        $errors->data->{$item->name} = $this->getErrorMessage($rule, $props);
                    }
                    break;
                }
            }
        }

        if (!is_null($errors)) {
            $this->app->response->end(400, $errors);
        }

        return TRUE;
    }

    private function validateFields($fields, $parent = NULL, &$errors = NULL, $fieldname = NULL) {
        foreach ($fields as $field) {
            $value = NULL;

            $curfieldname = is_null($fieldname) ? $field->name : $fieldname . '[' . $field->name . ']';

            if (!is_null($parent)) {
                if (is_object($parent)) {
    				if (isset($parent->{$field->name})) {
    					$value = $parent->{$field->name};
    				}
    			} else {
    				if (isset($parent[$field->name])) {
    					$value = $parent[$field->name];
    				}
    			}
            }

            if (is_null($value) && $field->type == 'array') {
                $value = array();
            }

            if (isset($field->options->rules)) {
                $this->validateField($field, $value, $errors, $curfieldname);
            }

            if ($field->type == 'object' && isset($field->sub)) {
                $this->validateFields($field->sub, $value, $errors, $curfieldname);
            }

            if ($field->type == 'array' && isset($field->sub)) {
                if (is_array($value) && count($value) > 0) {
                    foreach ($value as $i => $val) {
                        $this->validateFields($field->sub, $val, $errors, $curfieldname . '[' . $i . ']');
                    }
                } else {
                    $this->validateFields($field->sub, NULL, $errors, $curfieldname . '[0]');
                }
            }
        }

        return $errors;
    }

    private function validateField($field, $value, &$errors, $fieldname) {
        foreach ($field->options->rules as $rule => $props) {
            if (!$this->validateRule($rule, $value, $props)) {
                if (!isset($errors)) $errors = (object)array();
                $fieldname .= isset($field->multiple) ? '[]' : '';
                if (isset($field->fieldName)) {
                    if (!isset($errors->form)) $errors->form = (object)array();
                    $errors->form->{$fieldname} = $this->getErrorMessage($rule, $props);
                } else {
                    if (!isset($errors->data)) $errors->data = (object)array();
                    $errors->data->{$fieldname} = $this->getErrorMessage($rule, $props);
                }
                return;
            }
        }
    }

    private function validateRule($rule, $value, $props = NULL) {
		list($m, $r) = $this->splitRule($rule);
        $className = '\\lib\\validator\\rules\\' . $m;
        $module = $className::getInstance($this->app);
        return $module->{$r}($value, isset($props->param) ? $props->param : NULL);
    }

    private function getErrorMessage($rule, $props = NULL) {
        if (isset($props->message)) {
            $message = $props->message;
        } else {
            list($m, $r) = $this->splitRule($rule);
            $className = '\\lib\\validator\\messages\\en\\' . $m;
            $module = $className::getInstance();
            $message = $module->{$r};
        }

        $message = preg_replace_callback('/{([^}]+)}/', function($match) use ($props) {
            if (isset($props->param)) {
                if (is_array($props->param) && isset($props->param[$match[1]])) {
                    return $props->param[$match[1]];
                } elseif (is_object($props->param) && isset($props->param->{$match[1]})) {
                    return $props->param->{$match[1]};
                } elseif (is_string($props->param) || is_numeric($props->param)) {
                    return $props->param;
                }
            }
            return '';
        }, $message);

        return $message;
    }

	private function splitRule($rule) {
		if (strpos($rule, ':')) {
			return explode(':', $rule);
		} else {
			return array('core', $rule);
		}
	}
}
