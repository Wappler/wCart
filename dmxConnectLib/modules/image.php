<?php

namespace modules;

use \lib\core\Module;
use \lib\core\Scope;
use \lib\core\Path;
use \lib\core\FileSystem;
use \lib\image\Processor;

class image extends Module
{
    public $width;
    public $height;
    private $file;

    public function getImageSize($options) {
        option_require($options, 'path');

        $options = $this->app->parseObject($options);
        $path = Path::toSystemPath($options->path);

        return Processor::getImageSize($path);
    }

    public function load($options, $name) {
        option_require($options, 'path');
        option_default($options, 'autoOrient', FALSE);

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($name);
        $path = Path::toSystemPath($options->path);

        $this->file = $path;

        $image->load($path, $options->autoOrient);

        return $image;
    }

    public function save($options) {
        option_require($options, 'instance');
        option_require($options, 'path');
        option_default($options, 'format', pathinfo($this->file, PATHINFO_EXTENSION));
        option_default($options, 'template', '{name}{ext}');
		option_default($options, 'overwrite', false);
		option_default($options, 'createPath', true);
        option_default($options, 'quality', 75);

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);
        $path = Path::toSystemPath($options->path);

        if (!FileSystem::exists($path)) {
            if ($options->createPath) {
                if (!mkdir($path, 0777, TRUE)) {
                    throw new \Exception("Error creating path.");
                }
            } else {
                throw new \Exception("Path doesn't exist.");
            }
        }

        $path .= DIRECTORY_SEPARATOR . basename($this->file);

        if ($options->template) {
            $path = Path::parseTemplate($path, $options->template);
        }

        if (FileSystem::exists($path)) {
            if ($options->overwrite) {
                FileSystem::unlink($path);
            } else {
                $path = Path::getUniqFile($path);
            }
        }

        switch (strtolower($options->format)) {
            case 'jpg':
                $image->saveJPEG($path, $options->quality);
                break;
            case 'png':
                $image->savePNG($path);
                break;
            case 'gif':
                $image->saveGIF($path);
                break;
            default:
                $image->save($path, $options);
                break;
        }

        return Path::toAppPath($path);
    }


    // resize({ instance: 'ip', width: 800 }) resize with aspect to 800px width
    // resize({ instance: 'ip', width: '50%' }) resize to 50%
    // resize({ instance: 'ip', width: '200%', upscale: true }) resize to 200%, upscale must be set to true
    public function resize($options) {
        option_require($options, 'instance');
        option_default($options, 'width', 'auto');
        option_default($options, 'height', 'auto');
        option_default($options, 'upscale', FALSE);

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        if ($options->width == 'auto' && $options->height == 'auto') {
            return;
        } elseif ($options->width == 'auto') {
            $options->height = $image->ch($options->height);
            $options->width = $image->width * ($options->height / $image->height);
        } elseif ($options->height == 'auto') {
            $options->width = $image->cw($options->width);
            $options->height = $image->height * ($options->width / $image->width);
        } else {
            $options->width = $image->cw($options->width);
            $options->height = $image->ch($options->height);
        }

        if (!$options->upscale && ($options->width > $image->width || $options->height > $image->height)) {
            // do nothing when image is smaller then the new size and upscale is false
            return;
        }

        $image->resize($options->width, $options->height);
    }

    public function crop($options) {
        option_require($options, 'instance');
        option_require($options, 'x');
        option_require($options, 'y');
        option_require($options, 'width');
        option_require($options, 'height');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->crop($options->x, $options->y, $options->width, $options->height);
    }

    public function watermark($options) {
        option_require($options, 'instance');
        option_require($options, 'x');
        option_require($options, 'y');
        option_require($options, 'path');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);
        $path = Path::toSystemPath($options->path);

        $image->watermark($options->x, $options->y, $path);
    }

    public function text($options) {
        option_require($options, 'instance');
        option_require($options, 'x');
        option_require($options, 'y');
        option_require($options, 'text');
        option_require($options, 'font');
        option_default($options, 'size', 24);
        option_default($options, 'color', '#FFFFFF');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->text($options->x, $options->y, $options->text, $this->getFont($options->font), $options->size, $this->getColor($options->color));
    }

    public function tiled($options) {
        option_require($options, 'instance');
        option_require($options, 'path');
        option_default($options, 'padding', 0);

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);
        $path = Path::toSystemPath($options->path);

        $image->tiled($path, $options->padding);
    }

    public function flip($options) {
        option_require($options, 'instance');
        option_default($options, 'horizontal', FALSE);
        option_default($options, 'vertical', FALSE);

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        if ($options->horizontal && $options->vertical) {
            $image->flipBoth();
        } elseif ($options->horizontal) {
            $image->flipHorizontal();
        } elseif ($options->vertical) {
            $image->flipVertical();
        }
    }

    public function rotateLeft($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->rotateLeft();
    }

    public function rotateRight($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->rotateRight();
    }

    public function smooth($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->smooth();
    }

    public function blur($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->blur();
    }

    public function sharpen($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->sharpen();
    }

    public function meanRemoval($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->meanRemoval();
    }

    public function emboss($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->emboss();
    }

    public function edgeDetect($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->edgeDetect();
    }

    public function grayscale($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->grayscale();
    }

    public function sepia($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->sepia();
    }

    public function invert($options) {
        option_require($options, 'instance');

        $options = $this->app->parseObject($options);
        $image = $this->getInstance($options->instance);

        $image->invert();
    }

    private function getInstance($name) {
        return Processor::getInstance($name, $this->app);
    }

    private function getColor($color) {
        return intval(str_replace('#', '' ,$color), 16);
    }

    private function getFont($font) {
        return realpath(__DIR__ . '/../../dmxConnect/fonts/' . $font);
    }
}
