<?php

namespace lib\validator\rules;

class upload extends \lib\core\Singleton
{
    public function accept($value, $param) {
        $files = $this->getFiles($value);
        $allowed = explode(',', preg_replace('/\s/', '', $param));

        foreach ($files as $file) {
            $ok = FALSE;

            foreach ($allowed as $check) {
                if ($check[0] == '.') {
                    if (preg_match('/\\'. $check . '$/i', $file['name'])) {
                        $ok = TRUE;
                        break;
                    }
                } elseif (preg_match('/(audio|video|image)\/\*/i', $check)) {
                    if (preg_match('/^' . str_replace('*', '.*', $check) . '$/i', $file['type'])) {
                        $ok = TRUE;
                        break;
                    }
                } else {
                    if (strtolower($file['type']) == strtolower($check)) {
                        $ok = TRUE;
                        break;
                    }
                }
            }

            if (!$ok) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function minsize($value, $param) {
        $files = $this->getFiles($value);

        foreach ($files as $file) {
            if ($file['size'] < $param) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function maxsize($value, $param) {
        $files = $this->getFiles($value);

        foreach ($files as $file) {
            if ($file['size'] > $param) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function mintotalsize($value, $param) {
        $files = $this->getFiles($value);
        $size = 0;

        foreach ($files as $file) {
            $size += $file['size'];
        }

        return $size >= $param;
    }

    public function maxtotalsize($value, $param) {
        $files = $this->getFiles($value);
        $size = 0;

        foreach ($files as $file) {
            $size += $file['size'];
        }

        return $size <= $param;
    }

    public function minfiles($value, $param) {
        $files = $this->getFiles($value);

        return count($files) >= $param;
    }

    public function maxfiles($value, $param) {
        $files = $this->getFiles($value);

        return count($files) <= $param;
    }

    public function isValidFileValue($value) {
        return isset($value) && is_array($value) && count($value) > 0 && (isset($value['isFile']) || isset($value[0]['isFile']));
    }

    private function getFiles($value) {
        $files = array();

        if (is_array($value)) {
            if (isset($value['isFile']) && $value['isFile'] === TRUE && isset($value['error']) && $value['error'] == 0) {
                $files[] = $value;
            } else {
                foreach ($value as $i => $v) {
                    if (isset($v['isFile']) && $v['isFile'] === TRUE && isset($v['error']) && $v['error'] == 0) {
                        $files[] = $v;
                    }
                }
            }
        }

        return $files;
    }
}
