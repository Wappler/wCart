<?php

namespace lib\auth;

use lib\App;

class StaticProvider
{
	protected $users;
	protected $perms;

	public function __construct(App $app, $options) {
		option_require($options, 'users');
		option_require($options, 'perms');

		$this->users = $options->users;
		$this->perms = $options->perms;
	}

	public function validate($username,  $password) {
		if (isset($this->users->$username) && $this->users->$username == $password) {
			return $username;
		}

		return FALSE;
	}

	public function permissions($identity, $permissions) {
		foreach ($permissions as $permission) {
			if (!in_array($identity, $this->permissions->$permission)) {
				return FALSE;
			}
		}

		return TRUE;
	}
}
