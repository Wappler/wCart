<?php

namespace modules;

use \lib\core\Module;
use \lib\core\Scope;
use \lib\core\Path;
use \lib\mail\Mailer;

class mail extends Module
{
    public function setup($options, $name) {
        option_default($options, 'server', 'smtp');
        option_default($options, 'host', 'localhost');
		option_default($options, 'port', 25);
		option_default($options, 'useSSL', FALSE);
		option_default($options, 'username', '');
		option_default($options, 'password', '');

		$options = $this->app->parseObject($options);

        $this->getInstance($name)->setup($options);
    }

    public function send($options) {
        option_require($options, 'instance');
		option_require($options, 'subject');
		option_require($options, 'fromEmail');
		option_default($options, 'fromName', '');
		option_require($options, 'toEmail');
		option_default($options, 'toName', '');
		option_default($options, 'replyTo', '');
		option_default($options, 'cc', '');
		option_default($options, 'bcc', '');
		option_default($options, 'source', 'static'); // static/file
		option_default($options, 'contentType', 'text'); // text/html
		option_default($options, 'body', '');
        option_default($options, 'bodyFile', '');
		option_default($options, 'embedImages', FALSE);
		option_default($options, 'importance', 1); // 0 low, 1 normal, 2 high
		option_default($options, 'attachments', NULL); // '/file.ext' / ['/file.ext'] / {path:'/file.ext'} / [{path:'/file.ext'}]
        option_default($options, 'baseUrl', '/');

        $options = $this->app->parseObject($options);

        $options->from = $options->fromName != ''
            ? '"' . $options->fromName . '" <' . $options->fromEmail . '>'
            : $options->fromEmail;

        $options->to = $options->toName != ''
            ? '"' . $options->toName . '" <' . $options->toEmail . '>'
            : $options->toEmail;

        if ($options->source == 'file') {
            $options->bodyFile = Path::toSystemPath($options->bodyFile);
            $options->baseUrl = Path::toSiteUrl(dirname($options->bodyFile)) . '/';
            $options->body = $this->loadTemplate($options->bodyFile);
        }

        if ($options->attachments) {
            $options->attachments = Path::getFilesArray($options->attachments);
        }

        $this->getInstance($options->instance)->send($options);
    }

    private function getInstance($name) {
        return Mailer::getInstance($name, $this->app);
    }

    private function loadTemplate($path) {
        return $this->app->parseObject(file_get_contents($path));
    }
}
