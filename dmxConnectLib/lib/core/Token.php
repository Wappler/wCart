<?php

namespace lib\core;

class Token
{
	const STRING = 'STRING';
	const NUMBER = 'NUMBER';
	const REGEXP = 'REGEXP';
	const OPERATOR = 'OPERATOR';
	const IDENTIFIER = 'IDENTIFIER';
	const METHOD = 'METHOD';

	public $type;
	public $value;

	public function __construct($type, $value) {
		$this->type = $type;
		$this->value = $value;
	}
}