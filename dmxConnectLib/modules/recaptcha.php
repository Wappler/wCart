<?php

namespace modules;

use \lib\core\Module;

class recaptcha extends Module
{
    public function validate($options) {
		option_require($options, 'secret');
        option_default($options, 'msg', 'Recaptcha check failed.');

		if (!isset($_POST['g-recaptcha-response'])) {
			$this->app->response->end(400, (object)array('data' => (object)array('recaptcha' => 'Recaptcha check failed.')));
		}

		$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');

		if ($ch === FALSE) {
			throw new \Exception("Curl didn't initialize.");
		}

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array(
			'secret' => $options->secret,
			'response' => $_POST['g-recaptcha-response'],
			'remoteip' => $_SERVER['REMOTE_ADDR']
		));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = json_decode(curl_exec($ch));

		if ($result === FALSE) {
			throw new \Exception(curl_error($ch));
		}

		curl_close($ch);

		if (!$result->success) {
			$this->app->response->end(400, (object)array('form' => (object)array('g-recaptcha-response' => $options->msg)));
		}

		return $result;
	}
}
