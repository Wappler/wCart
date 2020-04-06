<?php

namespace modules;

use \lib\core\Module;
use \lib\core\Path;
use \lib\core\Scope;
use \lib\zip\Processor;

class zip extends Module
{
    public function zip($options) {
        option_require($options, 'zipfile'); // zip filename to create
		option_default($options, 'overwrite', FALSE); // overwrite existing zipfile
		option_require($options, 'files'); // array with files to zip
		option_default($options, 'comment', ''); // add comment to zip

        $options = $this->app->parseObject($options);

        $options->zipfile = Path::toSystemPath($options->zipfile);
        $options->files = Path::getFilesArray($options->files);

        if (!$options->overwrite) {
            $options->zipfile = Path::getUniqFile($options->zipfile);
        }

        return Path::toAppPath(Processor::zip($options));
    }

    public function zipdir($options) {
        option_require($options, 'zipfile'); // zip filename to create
		option_default($options, 'overwrite', FALSE); // overwrite existing zipfile
		option_require($options, 'path'); // folder to zip
		option_default($options, 'recursive', FALSE); // include all subfolders?
		option_default($options, 'comment', ''); // add comment to zip

        $options = $this->app->parseObject($options);

        $options->zipfile = Path::toSystemPath($options->zipfile);
        $options->path = Path::toSystemPath($options->path);

        if (!$options->overwrite) {
            $options->zipfile = Path::getUniqFile($options->zipfile);
        }

        return Path::toAppPath(Processor::zipdir($options));
    }

    public function unzip($options) {
        option_require($options, 'zipfile'); // zip filename to unzip
        option_require($options, 'destination'); // destination dir for unzip
        option_default($options, 'overwrite', TRUE); // overwrite existing files when unzipping

        $options = $this->app->parseObject($options);

        $options->zipfile = Path::toSystemPath($options->zipfile);
        $options->destination = Path::toSystemPath($options->destination);

        return Processor::unzip($options);
    }

    public function dir($options) {
        option_require($options, 'zipfile'); // zip filename to read files from

        $options = $this->app->parseObject($options);

        $options->zipfile = Path::toSystemPath($options->zipfile);

        return Processor::dir($options);
    }

    public function comment($options) {
        option_require($options, 'zipfile'); // zip filename to read files from

        $options = $this->app->parseObject($options);

        $options->zipfile = Path::toSystemPath($options->zipfile);

        return Processor::comment($options);
    }
}
