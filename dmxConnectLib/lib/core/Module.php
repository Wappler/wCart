<?php

namespace lib\core;

use \lib\App;

class Module
{
	protected $app;
	
	public function __construct(App $app) {
		$this->app = $app;
	}
}