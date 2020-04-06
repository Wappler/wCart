<?php

namespace lib\oauth;

use \lib\App;

class Oauth2
{
    protected $app;
    protected $options;

    public $access_token = NULL;

    public function __construct(App $app, $options, $name = '') {
        option_require($options, 'client_id');
        option_require($options, 'client_secret');
        option_require($options, 'token_endpoint');
        option_default($options, 'auth_endpoint', NULL);
        option_default($options, 'scope_separator', ' ');
        option_default($options, 'access_token', NULL);
        option_default($options, 'refresh_token', NULL);
        option_default($options, 'client_credentials', FALSE);
        option_default($options, 'verifySSL', TRUE);
        option_default($options, 'params', array());

        $this->app = $app;
        $this->name = $name;
        $this->options = $options;

        $this->access_token = $options->access_token;
        $this->refresh_token = $options->refresh_token;

        if (is_null($this->access_token)) {
            $this->access_token = $this->getSession('access_token');
        }

        if (is_null($this->refresh_token)) {
            $this->refresh_token = $this->getSession('refresh_token');
        }

        if (!is_null($this->access_token)) {
            $expires = $this->getSession('expires');

            if (!is_null($expires) && $expires - time() < 10) {
                $this->access_token = NULL;
                $this->removeSession('access_token');
                $this->removeSession('expires');

                if (!is_null($this->refresh_token)) {
                    $this->refreshToken($this->refresh_token);
                }
            }
        }

        if ($options->client_credentials && is_null($this->access_token)) {
            $response = $this->grant('client_credentials');
            $this->access_token = $response->access_token;
        }
    }

    public function authorize($scopes = array(), $params = array()) {
        $state = $this->get('state');

        if (!is_array($scopes)) $scopes = array();

        if ($state && $state == $this->getSession('state')) {
            $this->removeSession('state');

            if ($this->get('error')) {
                throw new \Exception($this->get('error_message', $this->get('error')));
            }

            if ($this->get('code')) {
                return $this->grant('authorization_code', array(
                    'redirect_uri' => $this->getRedirectUri(),
                    'code' => $this->get('code')
                ));
            }
        }

        $params = array_merge((array)$params, (array)$this->options->params, array(
            'response_type' => 'code',
            'client_id' => $this->options->client_id,
            'scope' => implode($this->options->scope_separator, $scopes),
            'redirect_uri' => $this->getRedirectUri(),
            'state' => $this->generateState()
        ));

        $this->setSession('state', $params['state']);

        $this->redirect($this->buildUri($this->options->auth_endpoint, $params));
    }

    public function refreshToken($refresh_token) {
        return $this->grant('refresh_token', array(
            'refresh_token' => $refresh_token
        ));
    }

    protected function grant($type, $params = array()) {
        $response = $this->httpPost($this->options->token_endpoint, array_merge($params, array(
            'grant_type' => $type,
            'client_id' => $this->options->client_id,
            'client_secret' => $this->options->client_secret
        )));

        if (isset($response->error)) {
            throw new \Exception(isset($response->error_description) ? $response->error_description : $response->error);
        }

        if (!isset($response->access_token)) {
            throw new \Exception('Http response has no access_token');
        }

        $this->setSession('access_token', $response->access_token);

        if (isset($response->expires_in)) {
            $this->setSession('expires', time() + $response->expires_in);
        }

        if (isset($response->refresh_token)) {
            $this->setSession('refresh_token', $response->refresh_token);
        }

        return $response;
    }

    protected function generateState() {
        $state = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);

        $this->setSession('state', $state);

        return $state;
    }

    protected function buildUri($endpoint, $params) {
        $uri = $endpoint;
        $uri .= strpos($uri, '?') === FALSE ? '?' : '&';
        $uri .= http_build_query($params);

        return $uri;
    }

    protected function getRedirectUri() {
        $https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
        $port = $_SERVER['SERVER_PORT'];

        $url = 'http';
        $url .= $https ? 's' : '';
        $url .= '://';
        $url .= $_SERVER['SERVER_NAME'];
        $url .= ($https && $port == '443') || (!$https && $port == '80') ? '' : ':' . $port;
        $url .= parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        return $url;
    }

    protected function get($key, $default = NULL) {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    protected function setSession($name, $value) {
        $this->app->session->set($this->name . '_' . $name, $value);
    }

    protected function getSession($name) {
        return $this->app->session->get($this->name . '_' . $name);
    }

    protected function removeSession($name) {
        $this->app->session->remove($this->name . '_' . $name);
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    protected function httpPost($url, $data) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->options->verifySSL);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new \Exception($error);
        }

        return json_decode($response);
    }
}
