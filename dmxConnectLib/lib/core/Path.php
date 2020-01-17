<?php

namespace lib\core;

use \lib\core\FileSystem;

class Path
{
    private function __construct() {}

	public static function getAppRoot() {
        static $appRoot = NULL;

        if ($appRoot === NULL) {
            $appRoot = FileSystem::realpath(__DIR__ . '/../../../');
        }

		return $appRoot;
	}

    public static function getSiteRoot() {
        static $siteRoot = NULL;

        if ($siteRoot === NULL) {
            $siteRoot = FileSystem::realpath($_SERVER['DOCUMENT_ROOT']);
        }

		return $siteRoot;
	}

    public static function isAppRoot($path) {
        return self::getAppRoot() == $path;
    }

	public static function isUnderAppRoot($path) {
		return strpos($path, self::getAppRoot()) === 0;
	}

    public static function toSystemPath($path) {
		if ($path[0] !== '/' || strpos($path, '..') !== FALSE) {
			throw new \Exception('Invalid Path! ' . $path);
		}

		$path = self::getAppRoot() . str_replace('/', DIRECTORY_SEPARATOR, $path);

        return $path;
    }

    public static function toAppPath($path) {
		if (!self::isUnderAppRoot($path) || strpos($path, '..') !== FALSE) {
			throw new \Exception('Invalid Path! ' . $path);
		}

        $path = str_replace('\\', '/', substr($path, strlen(self::getAppRoot())));

		return $path ? $path : '/';
    }

    public static function toSiteUrl($path) {
        if (strpos($path, self::getSiteRoot()) !== 0 || strpos($path, '..') !== FALSE) {
            //throw new \Exception('Invalid Path! ' . $path);
        }

        $path = str_replace('\\', '/', substr($path, strlen(self::getSiteRoot())));

		return $path ? $path : '/';
    }

    public static function getFilesArray($obj) {
        $files = array();

        if (!is_array($obj) || isset($obj['path'])) {
            $obj = array($obj);
        }

        foreach ($obj as $path) {
            if (is_array($path) && !isset($path['path'])) {
                $files = array_merge($files, self::getFilesArray($path));
            } else {
                $files[] = self::toSystemPath(is_array($path) && isset($path['path']) ? $path['path'] : (isset($path->path) ? $path->path : $path));
            }
        }

        return $files;
    }

    public static function getUniqFile($path) {
		$n = 1;

		while (FileSystem::exists($path)) {
			$path = preg_replace_callback('/(_(\d+))?(\.\w+)$/', function($matches) use ($n) {
				return '_' . $n . $matches[3];
			}, $path);

            if ($n > 999) {
                throw new \Exception("Couldn't create a unique filename. " . $path);
            }

            $n++;
		}

        return $path;
    }

    public static function parseTemplate($path, $template) {
        $n = 1;

        $dir = dirname($path) . DIRECTORY_SEPARATOR;
        $ext = '.' . pathinfo($path, PATHINFO_EXTENSION);
        $name = basename($path, $ext);
        $filename = str_replace(array('{name}', '{ext}'), array($name, $ext), $template);

        if (strpos($filename, '{guid}') !== FALSE) {
            $template = $filename;
            $filename = str_replace('{guid}', self::GUID(), $template);

            while (FileSystem::exists($dir . $filename)) {
                $filename = str_replace('{guid}', self::GUID(), $template);
            }
        }

        if (strpos($filename, '{_n}') !== FALSE) {
            $template = $filename;
            $filename = str_replace('{_n}', '', $template);

            while (FileSystem::exists($dir . $filename)) {
                $filename = str_replace('{_n}', '_' . $n++, $template);

                if ($n > 999) {
                    throw new \Exception("Couldn't create a unique filename. " . $filename);
                }
            }
        }

        return $dir . $filename;
    }

    private static function GUID() {
        if (function_exists('com_create_guid') === TRUE) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
