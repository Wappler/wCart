<?php

/*
	Special FileSystem class
	required for the differences between windows, linux and osx
	also making filesystem utf-8 aware
	TODO: encode and decode will only work on windows servers with a western europe charset, also charset on linux should be checked but are in most cases utf-8. windows should support multiple code pages (http://www.icosaedro.it/phplint/phplint2/libraries.htm - it\icosaedro\io\FileName, it\icosaedro\io\codepage\WindowsCodePage)
*/

namespace lib\core;

class FileSystem
{
	private function __construct() {}

	public static function isWindows() {
		return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
	}

	public static function encode($path) {
		if (self::isWindows() && preg_match('/[\x80-\xff]/', $path)) {
			$codepage = trim(strstr(setlocale(LC_CTYPE, 0), '.'), '.');
			
			if ($codepage && ctype_digit($codepage)) {
				if (function_exists('iconv')) {
					$path = iconv('UTF-8', 'CP' . $codepage . '//IGNORE', $path);
				} elseif (function_exists('mb_convert_encoding')) {
					$path = mb_convert_encoding($path, 'CP' . $codepage, 'UTF-8');
				}

				if ($path === FALSE) {
					throw new \Exception('Could not convert path.');
				}
			}
		}

		return $path;
	}

	public static function decode($path) {
		if (self::isWindows() && preg_match('/[\x80-\xff]/', $path)) {
			$codepage = trim(strstr(setlocale(LC_CTYPE, 0), '.'), '.');
			
			if ($codepage && ctype_digit($codepage)) {
				if (function_exists('iconv')) {
					$path = iconv('CP' . $codepage, 'UTF-8', $path);
				} elseif (function_exists('mb_convert_encoding')) {
					$path = mb_convert_encoding($path, 'UTF-8', 'CP' . $codepage);
				}
			}
			
			if ($path === FALSE) {
				throw new \Exception('Could not convert path.');
			}
		}
		
		return $path;
	}

	public static function chmod($path) {
		return chmod(self::encode($path));
	}

	public static function copy($source, $dest, $overwrite = FALSE) {
		$source = self::encode($source);
		$dest = self::encode($dest);

		if (self::exists($dest)) {
			if (!$overwrite) {
				throw new \Exception('Destination file already exists.');
			}

			self::unlink($dest);
		}

		return copy($source, $dest);
	}

	public static function exists($path) {
		return file_exists(self::encode($path));
	}

	public static function isdir($path) {
		return is_dir(self::encode($path));
	}

	public static function isfile($path) {
		return is_file(self::encode($path));
	}

	public static function mkdir($path, $mode = 0777, $recursive = FALSE) {
		return mkdir(self::encode($path), $mode, $recursive);
	}

	public static function readdir($path) {
		$entries = array();

		if ($handle = opendir(self::encode($path))) {
			while (($entry = readdir($handle)) !== FALSE) {
				if ($entry == '.' || $entry == '..') {
					continue;
				}

				if (strpos($entry, '?') !== FALSE) {
					//throw new \Exception('entry ' . $entry . ' contains invalid characters.');
					continue;
				}

				$entries[] = self::decode($entry);
			}

			closedir($handle);
		}

		return $entries;
	}

	public static function readfile($path) {
		return file_get_contents(self::encode($path));
	}

	public static function readjson($path) {
		return json_decode(self::readfile($path));
	}

	public static function realpath($path) {
		return self::decode(realpath(self::encode($path)));
	}

	public static function rename($oldPath, $newPath, $overwrite = FALSE) {
		$oldPath = self::encode($oldPath);
		$newPath = self::encode($newPath);

		if (self::exists($newPath)) {
			if (!$overwrite) {
				throw new \Exception('Destination file already exists.');
			}

			self::unlink($newPath);
		}

		return rename($oldPath, $newPath);
	}

	public static function rmdir($path) {
		return rmdir(self::encode($path));
	}

	public static function stat($path) {
		$encoded_path = self::encode($path);

		$stat = stat($encoded_path);

		if (!$stat) {
			throw new \Exception('stat() call failed.');
		}

		return array(
			'name' => substr($path, strrpos(str_replace('\\', '/', $path), '/') + 1),
			'path' => Path::toAppPath($path),
			'url' => Path::toSiteUrl($path),
			'type' => filetype($encoded_path),
			'size' => $stat['size'],
			'created'  => gmdate('Y-m-d\TH:i:s\Z', $stat['ctime']),
			'accessed' => gmdate('Y-m-d\TH:i:s\Z', $stat['atime']),
			'modified' => gmdate('Y-m-d\TH:i:s\Z', $stat['mtime'])
		);
	}

	public static function unlink($path) {
		return unlink(self::encode($path));
	}

	public static function move_uploaded_file($tmp, $path) {
		$tmp = self::encode($tmp);
		$path = self::encode($path);

		return move_uploaded_file($tmp, $path);
	}
}
