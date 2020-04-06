<?php

namespace lib\core;

use \lib\App;
use \lib\core\Token;
use \lib\core\RexExp;

class Lexer
{
    private $exp;
    private $pos;
    private $char;

    private $ops = array(
		'{', '}', '(', ')', '[', ']', '.', ',', ':', '?',
		'+', '-', '*', '/', '%',
		'===', '!==', '==', '!=',
		'<', '>', '<=', '>=', 'in',
		'&&', '||', '!',
		'&', '|', '^', '~',
		'<<', '>>', '>>>'
	);

	private $esc = array(
		'n' => '\n',
		'f' => '\f',
		'r' => '\r',
		't' => '\t',
		'v' => '\v',
		'"' => '"',
		"'" => "'"
	);

    public function parse($expression) {
		$tokens = array();

		$this->exp = $expression;
		$this->pos = 0;
		$op = TRUE;

		while ($this->pos < strlen($expression)) {
			$this->char = $this->read();

			if ($op && $this->detect_string()) {
				$tokens[] = new Token(Token::STRING, $this->read_string());
				$op = FALSE;
			} elseif ($op && $this->detect_number()) {
				$tokens[] = new Token(Token::NUMBER, $this->read_number());
				$op = FALSE;
			} elseif ($op && $this->detect_identifier()) {
				//$value = $this->readIdent();
				//$tokens[] = new Token($this->is($this->read(), '(') ? Token::METHOD : Token::IDENTIFIER, $value);
				$tokens[] = new Token(Token::IDENTIFIER, $this->read_identifier());
				$op = FALSE;
			} elseif ($op && $this->detect_regexp()) {
				$tokens[] = new Token(Token::REGEXP, $this->read_regexp());
				$op = FALSE;
			} elseif ($this->is_whitespace()) {
				// skip character
				$this->pos += 1;
			} else {
				if (in_array($this->read(3), $this->ops)) {
					$n = 3;
				} elseif (in_array($this->read(2), $this->ops)) {
					$n = 2;
				} elseif (in_array($this->char, $this->ops)) {
					$n = 1;
				} else {
					throw new \Exception('Unexpected character ' . $this->char . ' at column ' . $this->pos . ' in expression {{' . $this->exp . '}}');
				}

				$tokens[] = new Token(Token::OPERATOR, $this->consume($n));
				$op = TRUE;
			}
		}

		return $tokens;
	}

    private function read($n = 1) {
		return substr($this->exp, $this->pos, $n);
	}

	private function peek($n = 1) {
		$pos = $this->pos + $n;
		return $pos < strlen($this->exp) ? substr($this->exp, $pos, 1) : FALSE;
	}

	private function consume($n = 1) {
		$str = $this->read($n);
		$this->pos += $n;
		return $str;
	}

    private function detect_string() {
		return $this->is('\'"');
	}

	private function detect_number() {
		return $this->is('0123456789') ||
		      ($this->is('.') &&
		       $this->is('0123456789', $this->peek()));
	}

	private function detect_identifier() {
		return preg_match('/[a-zA-Z_$]/', $this->char);
	}

	private function detect_regexp() {
		return $this->is('/');
	}

    private function is($chars, $char = NULL) {
		if ($char == NULL) $char = $this->char;
		return strpos($chars, $char) !== FALSE;
	}

	private function is_whitespace() {
		$char = $this->char;
		return $char == ' '  || $char == '\r' || $char == '\t' ||
		       $char == '\n' || $char == '\v' || $char == '\u00A0';
	}

	private function isExpOperator($ch) {
		return $ch == '-' || $ch == '+' || $this->is_digid($ch);
	}

    private function read_string() {
		$quote = $this->char;
		$value = '';

		// skip quote
		++$this->pos;

		while ($this->pos < strlen($this->exp)) {
			$char = $this->consume();

			if ($char == '\\') {
				// escape character
				$char = $this->consume();

				if ($char == 'u') {
					// Unicode char escape
					$value .= chr($this->consume(4));
				}
				elseif (array_key_exists($char, $this->esc)) {
					$value .= $this->esc[$char];
				}
				else {
					$value .= $char;
				}
			}
			elseif ($char == $quote) {
				// end of string
				return $value;
			}
			else {
				$value .= $char;
			}
		}

		throw new \Exception('Unterminated string in expression {{' . $this->exp . '}}');
	}

    private function read_number() {
		preg_match('/^[0-9]*\\.?[0-9]+([eE][-+]?[0-9]+)?/', substr($this->exp, $this->pos, strlen($this->exp)), $match);
		return floatval($this->consume(strlen($match[0])));
	}

	private function read_identifier() {
		preg_match('/^[a-zA-Z0-9_$]+/', substr($this->exp, $this->pos, strlen($this->exp)), $match);
		return $this->consume(strlen($match[0]));
	}

    private function read_regexp() {
		$val = '';
		$mod = '';
		$esc = FALSE;

		$this->pos += 1;

		while ($this->pos < strlen($this->exp)) {
			$ch = $this->read();

			if ($esc) {
				$esc = FALSE;
			}
			elseif ($ch == '\\') {
				$esc = TRUE;
			}
			elseif ($ch == '/') {
				$this->pos += 1;

				while (strpos('ign', $ch = $this->read()) !== false) {
					$mod .= $ch;
					$this->pos += 1;
				}

				//return $val . '%%%' . $mod;
				return new RegExp($val, $mod);
			}

			$val .= $ch;
			$this->pos += 1;
		}

		throw new \Exception('Unterminated RegExp in expression {{' . $this->exp . '}}');
	}
}
