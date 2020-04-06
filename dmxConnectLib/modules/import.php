<?php

namespace modules;

use \lib\core\Module;
use \lib\core\Path;

class import extends Module
{
    public function csv($options, $name) {
        option_require($options, 'path');
        option_default($options, 'fields', array());
		option_default($options, 'header', FALSE);
		option_default($options, 'delimiter', ',');

		if ($options->delimiter == '\\t') $options->delimiter = "\t";

		$options = $this->app->parseObject($options);

        if (($fp = fopen(Path::toSystemPath($options->path), 'r')) !== FALSE) {
			$keys = $options->fields;
            $data = array();

            if (fread($fp, 3) !== chr(0xEF).chr(0xBB).chr(0xBF)) {
                rewind($fp);
            }

			if ($options->header) {
				$keys = fgetcsv($fp, 0, $options->delimiter);
                foreach ($options->fields as $field) {
                    if (!in_array($field, $keys)) {
                        $this->app->response->end(400, array(
                            "data" => array(
                                $name => "$field is missing in " . $options->path
                            )
                        ));
                    }
                }
			}

            while (($values = fgetcsv($fp, 0, $options->delimiter)) !== FALSE) {
                $o = array_combine($keys, $values);

                if (!$o) {
                    throw new \Exception('Error parsing CSV. ' + $options->path);
                }

                $data[] = $o;
            }

            fclose($fp);

            return $data;
        }

        throw new \Exception('Error loading CSV. ' + $options->path);
    }

	public function xml($options, $name) {
		option_require($options, 'path');
        option_default($options, 'fields', array());

		$options = $this->app->parseObject($options);

		$xml = simplexml_load_file(Path::toSystemPath($options->path), 'SimpleXMLElement', LIBXML_NOWARNING);

        $data = $xml->xpath('/*/*');

        for ($i = 0; $i < count($data); $i++) {
            $row = $data[$i];

            foreach ($options->fields as $field) {
                if (!isset($row->$field)) {
                    $this->app->response->end(400, array(
                        "data" => array(
                            $name => "$field is missing in " . $options->path
                        )
                    ));
                }
            }
        }

		return $data;
	}
}
