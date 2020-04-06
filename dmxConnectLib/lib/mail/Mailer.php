<?php

namespace lib\mail;

use \lib\mail\HtmlMimeMail;

class Mailer extends \lib\core\NamedSingleton
{
    private $server = 'smtp';
    private $host = 'localhost';
    private $port = 25;
    private $username = '';
    private $password = '';

    public function setup($options) {
        if (isset($options->server)) $this->server = $options->server;
        if (isset($options->host)) $this->host = $options->host;
        if (isset($options->port)) $this->port = $options->port;
        if (isset($options->useSSL) && $options->useSSL === TRUE) $this->host = 'ssl://' . $this->host;
        if (isset($options->username)) $this->username = $options->username;
        if (isset($options->password)) $this->password = $options->password;
    }

    public function send($options) {
        $mail = new HtmlMimeMail();

        if ($this->server == 'smtp') {
            $mail->setSMTPParams($this->host, $this->port, NULL, $this->username != '', $this->username, $this->password);
        }

        $mail->setSubject($options->subject);
        $mail->setFrom($options->from);

        if ($options->replyTo) {
            $mail->setHeader('Reply-To', $options->replyTo);
        }

        if ($options->cc) {
            $mail->setCc($options->cc);
        }

        if ($options->bcc) {
            $mail->setBcc($options->bcc);
        }

        if ($options->contentType == 'html') {
            $images = array();

            if ($options->embedImages) {
                $options->body = preg_replace_callback('/(?:"|\')([^"\']+\.(jpg|png|gif))(?:"|\')/Ui', function($matches) use (&$images, $options) {
    				$path = $matches[1];

    				if ($path[0] != '/') {
    					$path = $options->baseUrl . $path;
    				}

    				$path = realpath($_SERVER['DOCUMENT_ROOT'] . $path);

    				if (file_exists($path)) {
    					if (!isset($images[$path])) {
    						$images[$path] = 1;
    					}

    					return '"cid:' . basename($path) . '"';
    				}

    				return $matches[0];
                }, $options->body);

    			foreach ($images as $path => $cid) {
    				$image = $mail->getFile($path);
    				$mail->addHtmlImage($image, basename($path));
    			}
            }

			$options->body = preg_replace_callback('/(href|src)(?:\s*=\s*)(?:"|\')([^"\']+)(?:"|\')/Ui', function($matches) use ($options) {
				$path = $matches[2];

				if ($path[0] != '/') {
					$path = $options->baseUrl . $path;
				}

				if (strpos($path, ':') === FALSE) {
					return $matches[1] . '="http://' . $_SERVER['SERVER_NAME'] . $path . '"';
				}

				return $matches[0];
			}, $options->body);

			$mail->setHtml(str_replace('cid:', '', $options->body));
        } else {
            $mail->setText($options->body);
        }

        if ($options->attachments) {
            foreach ($options->attachments as $attachment) {
                $mail->addAttachment($mail->getfile($attachment), basename($attachment));
            }
        }

        switch ($options->importance) {
            case 0:
                $mail->setHeader('X-Priority', '5');
                $mail->setHeader('X-MSMail-Priority', 'Low');
                $mail->setHeader('Importance', 'Low');
                break;
            case 2:
                $mail->setHeader('X-Priority', '1');
                $mail->setHeader('X-MSMail-Priority', 'High');
                $mail->setHeader('Importance', 'High');
                break;
        }

        return $mail->send(array($options->to), $this->server == 'smtp' ? 'smtp' : 'mail');
    }
}
