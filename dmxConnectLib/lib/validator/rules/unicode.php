<?php

namespace lib\validator\rules;

class unicode extends \lib\core\Singleton
{
    public function unicodelettersonly($value, $param) {
        $arr = array('L');
        foreach ($param as $key => $val) {
            $arr[] =$key;
        }
        return !$this->isValidStringValue($value) || preg_match('/^(\p{' . implode('}|\p{', $arr) . '})+$/u', $value);
    }

    public function unicodescript($value, $param) {
        $arr = $param->scripts;
        foreach ($param as $key => $val) {
            if ($key != 'scripts') {
                $arr[] = $key;
            }
        }
        return !$this->isValidStringValue($value) || preg_match('/^(\p{' . implode('}|\p{', $arr) . '})+$/u', $value);
    }

    public function isValidStringValue($value) {
        return isset($value) && is_string($value) && strlen($value) > 0;
    }
}
