<?php

namespace lib\core;

class Singleton
{
    // here we store the instance once created
    private static $instances = array();

    // get the stored instance and create it if not exists
    public static function getInstance($app = NULL) {
		$cls = get_called_class();

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static($app);
        }

        return self::$instances[$cls];
    }

	// app instance will be injected here
    protected $app;

    // prevent creating new instances with the new operator outside of this class
    protected function __construct($app) {
        $this->app = $app;
    }

    // prevent cloning
    protected function __clone() {}

    // prevent unserializing
    public function __wakeup() {
		throw new Exception("Cannot unserialize singleton");
	}
}
