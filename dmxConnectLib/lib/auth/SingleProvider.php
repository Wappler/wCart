<?php

namespace lib\auth;

use lib\App;

class SingleProvider
{
	protected $username;
	protected $password;

	public function __construct(App $app, $options) {
		option_require($options, 'username');
		option_require($options, 'password');

		$this->username = $options->username;
		$this->password = $options->password;
	}

	public function validate($username, $password) {
		if ($username == $this->username && $password == $this->password) {
			return $username;
		}

		return FALSE;
	}

	public function permissions($identity, $permissions) {
		return TRUE;
	}
}
