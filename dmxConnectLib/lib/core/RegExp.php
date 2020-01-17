<?php

namespace lib\core;

class RegExp
{
    public $source;
	public $global = FALSE;
	public $ignoreCase = FALSE;
	public $multiline = FALSE;
	public $lastIndex = 0;

	public function __construct($pattern = '(?:)', $modifiers = '') {
		$this->source = $pattern;
		if (strpos($modifiers, 'g') !== FALSE) $this->global = TRUE;
		if (strpos($modifiers, 'i') !== FALSE) $this->ignoreCase = TRUE;
		if (strpos($modifiers, 'm') !== FALSE) $this->multiline = TRUE;
	}

	public function exec($string) {
		// convert lastIndex to bytes offset
		$offset = strlen(substr($string, 0, $this->lastIndex));

		if (preg_match($this->pattern(), $string, $matches, 0, $offset)) {
			// update lastIndex when global
			if ($this->global) {
				$this->lastIndex = strpos($string, $matches[0], $this->lastIndex) + strlen($matches[0]);
			}
			// return matches
			return $matches;
		}

		// no match, reset lastIndex
		$this->lastIndex = 0;

		return NULL;
	}

	public function test($string) {
		return $this->exec($string) !== NULL;
	}

	public function match($string) {
		if ($this->global) {
			preg_match_all($this->pattern(), $string, $matches);
			return $matches[0] ? $matches[0] : NULL;
		} else {
			preg_match($this->pattern(), $string, $matches);
			return $matches ? $matches : NULL;
		}
	}

	public function replace($string, $replace) {
		return preg_replace($this->pattern(), $replace, $string, $this->global ? -1 : 1);
	}

	public function search($string) {
		preg_match($this->pattern(), $string, $matches, PREG_OFFSET_CAPTURE);
		return isset($matches[0][1]) ? $matches[0][1] : -1;
	}

	public function split($string, $limit = -1) {
		if ($limit === 0) return array();
		return array_slice(preg_split($this->pattern(), $string), 0, $limit > 0 ? $limit : NULL);
	}

	private function pattern() {
		return '/' . $this->source . '/u'
			. ($this->ignoreCase ? 'i' : '')
			. ($this->multiline ? 'm' : '');
	}

	public function __toString() {
		return '/' . $this->source . '/'
			. ($this->global ? 'g' : '')
			. ($this->ignoreCase ? 'i' : '')
			. ($this->multiline ? 'm' : '');
	}
}
