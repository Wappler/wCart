<?php

namespace modules;

use \lib\core\Module;

use \Lcobucci\JWT\Builder;

class api extends Module
{
    /*
        $options
        {
            "alg": "String", // algorithm for signing (HS256, HS384, HS512, RS256, RS384, RS512, ES256, ES384, ES512)
            "key": "String", // key for signing
            "iss": "String", // issuer
            "sub": "String", // subject
            "aud": "String", // audience
            "jti": "String", // token id
            "iat": "Number", // time that the token was issued
            "nbf": "Number", // time before which the token cannot be accepted
            "exp": "Number", // expiration time
            "headers": "Object", // header items
            "claims": "Object" // claim items
        }
    */
    public function jwt($options) {
        $time = time();

        $builder = new Builder();

        if (isset($options->iss)) {
            $builder->issuedBy($options->iss);
        }

        if (isset($options->sub)) {
            $builder->relatedTo($options->sub);
        }

        if (isset($options->aud)) {
            $builder->canOnlyBeUsedBy($options->aud);
        }

        if (isset($options->jti)) {
            $builder->identifiedBy($options->jti, true);
        }

        if (isset($options->iat)) {
            $time = $options->iat;
        }

        $builder->issuedAt($time);
        $builder->canOnlyBeUsedAfter(isset($options->nbf) ? $options->nbf : $time + 60);
        $builder->expiresAt(isset($options->exp) ? $options->exp : $time + 3600);

        if (isset($options->headers)) {
            foreach ($options->headers as $key => $value) {
                $builder->withHeader($key, $value);
            }
        }

        if (isset($options->claims)) {
            foreach ($options->claims as $key => $value) {
                $builder->with($key, $value);
            }
        }

        if (isset($options->alg)) {
            if (!isset($options->key)) {
                throw new \Exception('API: option key is required for signing.');
            }

            switch ($options->alg) {
                case 'HS256':
                    $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
                    break;
                case 'HS384':
                    $signer = new \Lcobucci\JWT\Signer\Hmac\Sha384();
                    break;
                case 'HS512':
                    $signer = new \Lcobucci\JWT\Signer\Hmac\Sha512();
                    break;
                case 'RS256':
                    $signer = new \Lcobucci\JWT\Signer\Rsa\Sha256();
                    break;
                case 'RS384':
                    $signer = new \Lcobucci\JWT\Signer\Rsa\Sha384();
                    break;
                case 'RS512':
                    $signer = new \Lcobucci\JWT\Signer\Rsa\Sha512();
                    break;
                case 'ES256':
                    $signer = new \Lcobucci\JWT\Signer\Ecdsa\Sha256();
                    break;
                case 'ES384':
                    $signer = new \Lcobucci\JWT\Signer\Ecdsa\Sha384();
                    break;
                case 'ES512':
                    $signer = new \Lcobucci\JWT\Signer\Ecdsa\Sha512();
                    break;
                default:
                    throw new \Exception('API: unknown signing algorithm '.$options->alg.'.');
            }

            $builder->sign($signer, $options->key);
        }

        $token = $builder->getToken();

        return (string)$token;
    }

    public function get($options) {
        $options->method = 'GET';
        return $this->send($options);
    }

    public function post($options) {
        $options->method = 'POST';
        return $this->send($options);
    }

    public function put($options) {
        $options->method = 'PUT';
        return $this->send($options);
    }

    public function patch($options) {
        $options->method = 'PATCH';
        return $this->send($options);
    }

    public function delete($options) {
        $options->method = 'DELETE';
        return $this->send($options);
    }

    public function send($options) {
        option_require($options, 'url');
        option_default($options, 'method', 'GET');
        option_default($options, 'data', NULL);
        option_default($options, 'dataType', 'auto');
        option_default($options, 'verifySSL', FALSE);
        option_default($options, 'params', array());
        option_default($options, 'headers', array());
        option_default($options, 'username', '');
        option_default($options, 'password', '');
        option_default($options, 'oauth', NULL);
        option_default($options, 'passErrors', TRUE);

        $options = $this->app->parseObject($options);

        $url = $options->url;
        $method = $options->method;
        $headers = (array)$options->headers;
        $data = NULL;

        $handle = curl_init();

        if ($method != 'GET') {
            $data = $options->data;

            if ($options->dataType != 'auto') {
                if (!isset($headers['Content-Type'])) {
                    $headers['Content-Type'] = 'application/' . $options->dataType;
                }
                if ($options->dataType == 'x-www-form-urlencoded') {
                    $data = http_build_query($options->data);
                } else {
                    $data = json_encode($options->data);
                }
            } elseif ($method == 'POST') {
                curl_setopt($handle, CURLOPT_POST, TRUE);
            }

            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        }

        if ($options->oauth) {
            $oauth2 = $this->app->scope->get($options->oauth);
            if ($oauth2 && $oauth2->access_token) {
                $headers['Authorization'] = 'Bearer ' . $oauth2->access_token;
            }
        }

        foreach ($options->params as $name => $value) {
            if (strpos($url, '?') !== FALSE) {
                $url .= '&';
            } else {
                $url .= '?';
            }

            $url .= curl_escape($handle, $name) . '=' . curl_escape($handle, $value);
        }

        curl_setopt_array($handle, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTPHEADER => $this->getFormatterHeaders($headers),
            CURLOPT_HEADER => TRUE,
            CURLOPT_ENCODING => '',
            CURLOPT_SSL_VERIFYPEER => $options->verifySSL
        ]);

        if (isset($options->timeout)) {
            curl_setopt($handle, CURLOPT_TIMEOUT, $options->timeout);
        }

        if (!empty($options->username)) {
            curl_setopt_array($handle, [
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_USERPWD => $options->username . ':' . $options->password
            ]);
        }

        $response = curl_exec($handle);
        $error = curl_error($handle);
        $info = curl_getinfo($handle);

        curl_close($handle);

        if ($error) {
            throw new \Exception($error);
        }

        $headerSize = $info['header_size'];
        $rawHeaders = substr($response, 0, $headerSize);
        $rawBody = substr($response, $headerSize);
        $status = $info['http_code'];

        if ($options->passErrors && $status >= 400) {
            $this->app->response->end($status, $this->parseBody($rawBody));
        }

        return (object)[
            'status' => $status,
            'headers' => $this->parseHeaders($rawHeaders),
            'data' => $this->parseBody($rawBody)
        ];
    }

    protected function parseHeaders($rawHeaders) {
        if (function_exists('http_parse_headers')) {
            return http_parse_headers($rawHeaders);
        } else {
            $key = '';
            $headers = array();

            foreach (explode("\n", $rawHeaders) as $i => $h) {
                $h = explode(':', $h, 2);

                if (isset($h[1])) {
                    if (!isset($headers[$h[0]])) {
                        $headers[$h[0]] = trim($h[1]);
                    } elseif (is_array($headers[$h[0]])) {
                        $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
                    } else {
                        $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1])));
                    }

                    $key = $h[0];
                } else {
                    if (substr($h[0], 0, 1) == "\t") {
                        $headers[$key] .= "\r\n\t".trim($h[0]);
                    } elseif (!$key) {
                        $headers[0] = trim($h[0]);
                    }
                }
            }

            return $headers;
        }
    }

    protected function parseBody($rawBody) {
        $json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $rawBody));

        if (json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }

        return $rawBody;
    }

    protected function getFormatterHeaders($headers = array()) {
        $formattedHeaders = array();

        foreach ($headers as $key => $val) {
            $formattedHeaders[] = $this->getHeaderString($key, $val);
        }

        if (!array_key_exists('user-agent', $headers)) {
            $formattedHeaders[] = 'user-agent: ServerConnect/1.0';
        }

        if (!array_key_exists('accept', $headers)) {
            $formattedHeaders[] = 'accept: application/json';
        }

        if (!array_key_exists('expect', $headers)) {
            $formattedHeaders[] = 'expect:';
        }

        return $formattedHeaders;
    }

    protected function getHeaderString($key, $val) {
        $key = trim(strtolower($key));
        return $key . ':' . $val;
    }
}
