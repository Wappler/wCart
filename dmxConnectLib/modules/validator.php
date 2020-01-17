<?php

namespace modules;

use \lib\core\Module;
use \lib\core\Scope;

class validator extends Module
{
    // sends a 400 error to browser when there are errors
    public function validate($options) {
        $data = $this->app->parseObject($options->data);
        $validator = \lib\validator\Validator::getInstance($this->app);

        // return true if validation was successful
        return $validator->validate($data);
    }

    public function error($options, $name) {
        option_require($options, 'message');

        $options = $this->app->parseObject($options);

        if (isset($options->fieldName)) {
            $error = array(
                "form" => array(
                    $options->fieldName => $options->message
                )
            );
        } else {
            $error = array(
                "data" => array(
                    $name => $options->message
                )
            );
        }

        $this->app->response->end(400, $error);
    }
}
