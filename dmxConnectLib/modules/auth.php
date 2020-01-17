<?php

namespace modules;

use \lib\core\Module;
use \lib\auth\Provider;

class auth extends Module
{
	public function provider($options, $name = NULL) {
		return new Provider($this->app, $options, $name);
	}

	public function validate($options) {
		$provider = $this->app->scope->get($options->provider);

		switch ($_POST['action']) {
			case 'login':
				$provider->login($_POST['username'], $_POST['password'], $_POST['remember'] != '');
				break;

			case 'logout':
			$provider->logout();
			break;
		}

		if (!$provider->identity) {
			$this->app->response->end(401);
		}

		$this->app->data['identity'] = $provider->identity;
	}

	public function login($options) {
		option_require($options, 'provider');
		option_default($options, 'username', '{{$_POST.username}}');
		option_default($options, 'password', '{{$_POST.password}}');
		option_default($options, 'remember', '{{$_POST.remember}}');

		$options = $this->app->parseObject($options);

		$provider = $this->app->scope->get($options->provider);

		return $provider->login($options->username, $options->password, $options->remember);
	}

	public function logout($options) {
		option_require($options, 'provider');

		$options = $this->app->parseObject($options);

		$provider = $this->app->scope->get($options->provider);

		return $provider->logout();
	}

	public function restrict($options) {
		option_require($options, 'provider');

		$options = $this->app->parseObject($options);

		$provider = $this->app->scope->get($options->provider);

		return $provider->restrict($options);
	}
}
