<?php

namespace modules;

use \lib\core\Module;
use \lib\core\Path;

class export extends Module
{
  public function csv($options) {
    option_require($options, 'path');
    option_require($options, 'data');
		option_default($options, 'header', FALSE);
		option_default($options, 'delimiter', ',');
    option_default($options, 'overwrite', FALSE);
    option_default($options, 'nobom', FALSE);

		if ($options->delimiter == '\\t') $options->delimiter = "\t";

		$options = $this->app->parseObject($options);

    $options->path = Path::toSystemPath($options->path);

    if (!$options->overwrite) {
      $options->path = Path::getUniqFile($options->path);
    }

		if (!is_array($options->data)) {
			throw new \Exception('Data is not an array.');
		}

    if (count($options->data) === 0) {
			throw new \Exception('Data is empty.');
		}

    $fp = fopen($options->path, 'w');
    if (!$options->nobom) {
		  fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
    }

		if ($options->header) {
			fputcsv($fp, array_keys((array)$options->data[0]), $options->delimiter);
		}

    foreach ($options->data as $value) {
      fputcsv($fp, (array)$value, $options->delimiter);
    }

    fclose($fp);

    return Path::toAppPath($options->path);
  }

	public function xml($options) {
		option_require($options, 'path');
		option_require($options, 'data');
		option_default($options, 'root', 'export');
		option_default($options, 'item', 'item');
    option_default($options, 'overwrite', FALSE);

		$options = $this->app->parseObject($options);

    $options->path = Path::toSystemPath($options->path);

    if (!$options->overwrite) {
      $options->path = Path::getUniqFile($options->path);
    }

		if (!is_array($options->data)) {
			throw new \Exception('Data is not an array.');
		}

    if (count($options->data) === 0) {
			throw new \Exception('Data is empty.');
		}

		if (($fp = fopen($options->path, 'w')) !== FALSE) {
			fwrite($fp, '<?xml version="1.0" encoding="UTF-8" ?>');
			fwrite($fp, "<{$options->root}>");
			foreach ($options->data as $data) {
				fwrite($fp, "<{$options->item}>");
				foreach ((array)$data as $key => $val) {
					fwrite($fp, "<$key><![CDATA[$val]]></$key>");
				}
				fwrite($fp, "</{$options->item}>");
			}
			fwrite($fp, "</{$options->root}>");

			fclose($fp);

			return Path::toAppPath($options->path);
		}

		throw new \Exception('Error!');
	}
}
