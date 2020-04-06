<?php

namespace lib\core;

use \lib\App;
use \lib\core\Scope;
use \lib\core\Lexer;

if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'formatters.php')) {
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'formatters.php');
}

$formatters_folder = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'formatters';
if (file_exists($formatters_folder) && is_dir($formatters_folder)) {
    foreach (FileSystem::readdir($formatters_folder) as $entry) {
        if (substr($entry, -4) === ".php") {
            include_once($formatters_folder . DIRECTORY_SEPARATOR . $entry);
        }
    }
}

class Parser
{
    const OP_LEFT_CURLY = '{';
    const OP_RIGHT_CURLY = '}';
    const OP_LEFT_PAREN = '(';
    const OP_RIGHT_PAREN = ')';
    const OP_LEFT_BRACKET = '[';
    const OP_RIGHT_BRACKET = ']';
    const OP_DOT = '.';
    const OP_COMMA = ',';
    const OP_COLON = ':';
    const OP_HOOK = '?';
    const OP_PLUS = '+';
    const OP_MINUS = '-';
    const OP_MUL = '*';
    const OP_DIV = '/';
    const OP_MOD = '%';
    const OP_LOGICAL_AND = '&&';
    const OP_LOGICAL_OR = '||';
    const OP_LOGICAL_NOT = '!';
    const OP_BITWISE_AND = '&';
    const OP_BITWISE_OR = '|';
    const OP_BITWISE_XOR = '^';
    const OP_BITWISE_NOT = '~';
    const OP_STRICT_EQ = '===';
    const OP_EQ = '==';
    const OP_STRICT_NE = '!==';
    const OP_NE = '!=';
    const OP_LSH = '<<';
    const OP_LE = '<=';
    const OP_LT = '<';
    const OP_URSH = '>>>';
    const OP_RSH = '>>';
    const OP_GE = '>=';
    const OP_GT = '>';
    const OP_IN = 'in';

    public $scope;

    private $app;
    private $tokens = array();
    private $reserved = array();

    public function __construct(App $app) {
        $this->app = $app;

        $self = &$this;

        $this->reserved['PI'] = function() use (&$self) { return pi(); };
        $this->reserved['NOW'] = function() use (&$self) { return date('Y-m-d\TH:i:s'); };
        $this->reserved['NOW_UTC'] = function() use (&$self) { return gmdate('Y-m-d\TH:i:s\Z'); };
        $this->reserved['TIMESTAMP'] = function() use (&$self) { return time(); };
		$this->reserved['$this'] = function() use (&$self) { return $self->scope->data; };
		$this->reserved['$global'] = function() use (&$self) { return $self->scope->global->data; };
		$this->reserved['$parent'] = function() use (&$self) { return isset($self->scope->parent) ? $self->scope->parent->data : NULL; };
		$this->reserved['null'] = function() use (&$self) { return NULL; };
		$this->reserved['true'] = function() use (&$self) { return TRUE; };
		$this->reserved['false'] = function() use (&$self) { return FALSE; };
    }

    public function parse($expression, Scope $scope = NULL) {
        $this->scope = $scope !== NULL ? $scope : $this->app->scope;
        $this->tokens = $this->app->lexer->parse($expression);

        $value = $this->expression();

        return $value();
    }

    private function read() {
        if (count($this->tokens) == 0) {
            throw new Exception('Unexpected end of expression.');
        }

        return $this->tokens[0];
    }

    private function peek($value = NULL, $type = NULL) {
        if (count($this->tokens) > 0) {
            $token = $this->tokens[0];

            if (is_array($value)) {
                foreach ($value as $val) {
                    if ($token->value === $val && ($type === NULL || $type === $token->type)) {
                        return $token;
                    }
                }
            } elseif (($value === NULL || $value === $token->value) && ($type === NULL || $type == $token->type)) {
                return $token;
            }
        }

        return FALSE;
    }

    private function expect($e = NULL, $type = NULL) {
        $token = $this->peek($e, $type);

        if ($token !== FALSE) {
            array_shift($this->tokens);
            return $token;
        }

        return FALSE;
    }

    private function consume($e) {
        if ($this->expect($e) === FALSE) {
            throw new \Exception('Unexpected token, expecting (' . $e . ').');
        }
    }

    private function fn($exp) {
        return function() use ($exp) {
            return $exp;
        };
    }

    private function expression() {
        return $this->conditional();
    }

    private function conditional() {
        $left = $this->logicalOr();

        if ($token = $this->expect(self::OP_HOOK, Token::OPERATOR)) {
            $middle = $this->expression();

            if ($token = $this->expect(self::OP_COLON, Token::OPERATOR)) {
                return self::execute($token->value, $left, $middle, $this->expression());
            } else {
                throw new \Exception('Unexpected token, Expecting (:).');
            }
        } else {
            return $left;
        }
    }

    private function logicalOr() {
        $left = $this->logicalAnd();

        while (true) {
            if ($token = $this->expect(self::OP_LOGICAL_OR, Token::OPERATOR)) {
                $left = self::execute($token->value, $left, $this->logicalAnd());
            } else {
                return $left;
            }
        }
    }

    private function logicalAnd() {
        $left = $this->bitwiseOr();

        if ($token = $this->expect(self::OP_LOGICAL_AND, Token::OPERATOR)) {
            $left = self::execute($token->value, $left, $this->logicalAnd());
        }

        return $left;
    }

    private function bitwiseOr() {
        $left = $this->bitwiseXor();

        if ($token = $this->expect(self::OP_BITWISE_OR, Token::OPERATOR)) {
            $left = self::execute($token->value, $left, $this->logicalXor());
        }

        return $left;
    }

    private function bitwiseXor() {
        $left = $this->bitwiseAnd();

        if ($token = $this->expect(self::OP_BITWISE_XOR, Token::OPERATOR)) {
            $left = self::execute($token->value, $left, $this->logicalAnd());
        }

        return $left;
    }

    private function bitwiseAnd() {
        $left = $this->equality();

        if ($token = $this->expect(self::OP_BITWISE_AND, Token::OPERATOR)) {
            $left = self::execute($token->value, $left, $this->equality());
        }

        return $left;
    }

    private function equality() {
		$left = $this->relational();

		if ($token = $this->expect(array(self::OP_EQ, self::OP_NE, self::OP_STRICT_EQ, self::OP_STRICT_NE), Token::OPERATOR)) {
			$left = self::execute($token->value, $left, $this->equality());
		}

		return $left;
	}

    	private function relational() {
		$left = $this->bitwiseShift();

		if ($token = $this->expect(array(self::OP_LT, self::OP_LE, self::OP_GT, self::OP_GE, self::OP_IN), Token::OPERATOR)) {
			$left = self::execute($token->value, $left, $this->relational());
		}

		return $left;
	}

	private function bitwiseShift() {
		$left = $this->addictive();

		while ($token = $this->expect(array(self::OP_LSH, self::OP_RSH, self::OP_URSH), Token::OPERATOR)) {
			$left = self::execute($token->value, $left, $this->addictive());
		}

		return $left;
	}

	private function addictive() {
		$left = $this->multiplicative();

		while ($token = $this->expect(array(self::OP_PLUS, self::OP_MINUS), Token::OPERATOR)) {
			$left = self::execute($token->value, $left, $this->multiplicative());
		}

		return $left;
	}

	private function multiplicative() {
		$left = $this->unary();

		while ($token = $this->expect(array(self::OP_MUL, self::OP_DIV, self::OP_MOD), Token::OPERATOR)) {
			$left = self::execute($token->value, $left, $this->unary());
		}

		return $left;
	}

	private function unary() {
		if ($token = $this->expect(array(self::OP_PLUS, self::OP_MINUS), Token::OPERATOR)) {
			if ($token->value == self::OP_PLUS) {
				return $this->group();
			}

			return self::execute($token->value, $this->fn(0), $this->unary());
		} elseif ($token = $this->expect(self::OP_LOGICAL_NOT, Token::OPERATOR)) {
			return self::execute($token->value, $this->unary());
		}

		return $this->group();
	}

    private function group() {
		if ($this->expect(self::OP_LEFT_PAREN, Token::OPERATOR)) {
			$value = $this->expression();
			$this->consume(self::OP_RIGHT_PAREN, Token::OPERATOR);

			while ($next = $this->expect(array(self::OP_LEFT_BRACKET, self::OP_DOT), Token::OPERATOR)) {
				if ($next->value == self::OP_LEFT_BRACKET) {
					// index
					$value = $this->fn($this->objectIndex($value));
				} elseif ($next->value == self::OP_DOT) {
					// member
					$value = $this->fn($this->objectMember($value));
				} else {
					throw new \Exception('Unexpected token ('.$next->value.').');
				}
			}

			return $value;
		}

		return $this->primary();
	}

    private function primary() {
        $token = $this->expect();

        if ($token === FALSE) {
            throw new \Exception('Unexpected end of tokens.');
        }

        $value = $this->fn($token->value);

        switch ($token->type) {
            case Token::IDENTIFIER:
                if (array_key_exists($token->value, $this->reserved)) {
                    $value = $this->reserved[$token->value];
                } elseif ($this->scope->has($token->value)) {
                    $value = $this->fn($this->scope->get($token->value));
                } else {
                    $value = $this->fn(NULL);
                }
                break;

            case Token::OPERATOR:
                if ($token->value == self::OP_LEFT_BRACKET) {
                    $arr = array();

                    do {
                        $val = $this->expression();
                        $arr[] = $val();
                    } while ($this->expect(self::OP_COMMA));

                    $value = $this->fn($arr);

                    $this->consume(self::OP_RIGHT_BRACKET);
                } elseif ($token->value == self::OP_LEFT_CURLY) {
                    $obj = array();

                    do {
                        $key = $this->expect()->value;
                        $this->consume(self::OP_COLON);
                        $val = $this->expression();
                        $obj[$key] = $val();
                    } while ($this->expect(self::OP_COMMA));

                    $value = $this->fn((object)$obj);

                    $this->consume(self::OP_RIGHT_CURLY);
                } else {
                    throw new \Exception('Unexpected operator token (' . $token->value . ')');
                }
                break;
        }

        while ($next = $this->expect(array(self::OP_LEFT_BRACKET, self::OP_DOT), Token::OPERATOR)) {
            if ($next->value == self::OP_LEFT_BRACKET) {
                $value = $this->fn($this->objectIndex($value));
            } elseif ($next->value == self::OP_DOT) {
                $value = $this->fn($this->objectMember($value));
            } else {
                throw new \Exception('Unexpected token (' . $next->value . ')');
            }
        }

        return $value;
    }

    private function objectIndex($value) {
		$index = $this->expression();
		$index = $index();

		$this->consume(self::OP_RIGHT_BRACKET);

		$data = $value();

		return $this->getProperty($data, $index);
	}

    private function objectMember($value) {
		$token = $this->expect(NULL, Token::IDENTIFIER);

		if (!$token) {
			throw new \Exception('Unexpected token (' . $this->peek()->value . ').');
		}

		$data = $value();

		if ($this->expect(self::OP_LEFT_PAREN, Token::OPERATOR)) {
			$args = array($data);

			if ($this->peek()->value !== self::OP_RIGHT_PAREN) {
				do {
					$arg = $this->expression();
					$args[] = $arg();
				} while ($this->expect(self::OP_COMMA, Token::OPERATOR));
			}

			$this->consume(self::OP_RIGHT_PAREN);

			if (is_callable('\lib\core\formatter_'.$token->value)) {
				return call_user_func_array('\lib\core\formatter_'.$token->value, $args);
			} else {
				//return NULL;
                throw new \Exception('Formatter ' . $token->value . ' does not exist.');
			}
		}

		return $this->getProperty($data, $token->value);
	}

    private function getProperty($object, $prop) {
		switch (gettype($object)) {
			case 'string':
				return $prop === 'length' ? utf8_strlen($object) : NULL;

			case 'array':
				return $prop === 'length' ? count($object) : (isset($object[$prop]) ? $object[$prop] : NULL);

			case 'object':
				return isset($object->$prop) ? $object->$prop : NULL;

			default:
				return NULL;
		}
	}

    public static function execute($op, $a, $b = null, $c = null) {
		switch ($op) {
			case self::OP_COLON:
				return function() use ($a, $b, $c) {
					return $a() ? $b() : $c();
				};

			case self::OP_LOGICAL_OR:
				return function() use ($a, $b) {
					return $a() || $b();
				};

			case self::OP_LOGICAL_AND:
				return function() use ($a, $b) {
					return $a() && $b();
				};

			case self::OP_BITWISE_OR:
				return function() use ($a, $b) {
					return $a() | $b();
				};

			case self::OP_BITWISE_XOR:
				return function() use ($a, $b) {
					return $a() ^ $b();
				};

			case self::OP_BITWISE_AND:
				return function() use ($a, $b) {
					return $a() & $b();
				};

			case self::OP_EQ:
				return function() use ($a, $b) {
					return $a() == $b();
				};

			case self::OP_NE:
				return function() use ($a, $b) {
					return $a() != $b();
				};

			case self::OP_STRICT_EQ:
				return function() use ($a, $b) {
					return $a() === $b();
				};

			case self::OP_STRICT_NE:
				return function() use ($a, $b) {
					return $a() !== $b();
				};

			case self::OP_LT:
				return function() use ($a, $b) {
					return $a() < $b();
				};

			case self::OP_LE:
				return function() use ($a, $b) {
					return $a() <= $b();
				};

			case self::OP_GT:
				return function() use ($a, $b) {
					return $a() > $b();
				};

			case self::OP_GE:
				return function() use ($a, $b) {
					return $a() >= $b();
				};

			case self::OP_IN:
				return function() use ($a, $b) {
					// TODO: simulate the in operation from javascript
					// return $a() in $b();
					$aa = $a();
					$bb = $b();

					if (is_array($bb)) {
						return array_key_exists($aa, $bb);
					}

					if (is_object($bb)) {
						return property_exists($bb, $aa);
					}

					return false;
				};

			case self::OP_LSH:
				return function() use ($a, $b) {
					return $a() << $b();
				};

			case self::OP_RSH:
				return function() use ($a, $b) {
					return $a() >> $b();
				};

			case self::OP_URSH:
				return function() use ($a, $b) {
					return $a() >> $b();
				};

			case self::OP_PLUS:
				return function() use ($a, $b) {
					$aa = $a();
					$bb = $b();

					if (is_string($aa) || is_string($bb)) {
						return $aa . $bb;
					}

					return $aa + $bb;
				};

			case self::OP_MINUS:
				return function() use ($a, $b) {
					return $a() - $b();
				};

			case self::OP_MUL:
				return function() use ($a, $b) {
					return $a() * $b();
				};

			case self::OP_DIV:
				return function() use ($a, $b) {
					return $a() / $b();
				};

			case self::OP_MOD:
				return function() use ($a, $b) {
					return $a() % $b();
				};

			case self::OP_LOGICAL_NOT:
				return function() use ($a) {
					return !$a();
				};

			case self::OP_BITWISE_NOT:
				return function() use ($a) {
					return ~$a();
				};
		}
	}
}
