<?php

// Social Logins (https://github.com/26medias/social-login/blob/master/social-login.js)
// Passport packages (http://www.passportjs.org/packages/)

namespace modules;

use \lib\core\Module;
use \lib\oauth\Oauth2;

class oauth extends Module
{
    public function provider($options, $name) {
        option_default($options, 'service', NULL);
        option_default($options, 'params', (object)array());

        /*
            google (https://developers.google.com/identity/protocols/OAuth2WebServer#creatingclient)
              * include_granted_scopes
              * login_hint
              * prompt
            facebook (https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow)
              * display=popup
              * auth_type=rerequest
            linkedin (https://developer.linkedin.com/docs/oauth2)
            github (https://github.com/jaredhanson/passport-github)
            instagram (https://github.com/jaredhanson/passport-instagram)
            amazon (https://github.com/jaredhanson/passport-amazon)
            dropbox (https://github.com/florianheinemann/passport-dropbox-oauth2)
            foursquare (https://github.com/jaredhanson/passport-foursquare)
            imgur (https://github.com/mindfreakthemon/passport-imgur)
            wordpress (https://github.com/mjpearson/passport-wordpress)
            spotify (https://developer.spotify.com/documentation/general/guides/authorization-guide/)
            slack (https://api.slack.com/docs/sign-in-with-slack#identify_users_and_their_teams)
            reddit (https://github.com/Slotos/passport-reddit)
            twitch (https://github.com/Schmoopiie/passport-twitch)
            paypal (https://github.com/jaredhanson/passport-paypal-oauth)
            pinterest (https://github.com/analog-nico/passport-pinterest)
            stripe (https://github.com/mathisonian/passport-stripe)
            coinbase (https://github.com/digitaltangibletrust/passport-coinbase)
        */

        switch ($options->service) {
            case 'google':
                $options->auth_endpoint = 'https://accounts.google.com/o/oauth2/v2/auth';
                $options->token_endpoint = 'https://www.googleapis.com/oauth2/v4/token';
                $options->params->access_type = 'offline';
            break;

            case 'facebook':
                $options->auth_endpoint = 'https://www.facebook.com/v3.2/dialog/oauth';
                $options->token_endpoint = 'https://graph.facebook.com/v3.2/oauth/access_token';
            break;

            case 'linkedin':
                $options->auth_endpoint = 'https://www.linkedin.com/oauth/v2/authorization';
                $options->token_endpoint = 'https://www.linkedin.com/oauth/v2/accessToken';
            break;

            case 'github':
                $options->auth_endpoint = 'https://github.com/login/oauth/authorize';
                $options->token_endpoint = 'https://github.com/login/oauth/access_token';
            break;

            case 'instagram':
                $options->auth_endpoint = 'https://api.instagram.com/oauth/authorize/';
                $options->token_endpoint = 'https://api.instagram.com/oauth/access_token';
            break;

            case 'amazon':
                $options->auth_endpoint = 'https://www.amazon.com/ap/oa';
                $options->token_endpoint = 'https://api.amazon.com/auth/o2/token';
            break;

            case 'dropbox':
                $options->auth_endpoint = 'https://www.dropbox.com/oauth2/authorize';
                $options->token_endpoint = 'https://api.dropbox.com/oauth2/token';
                $options->scope_separator = ',';
            break;

            case 'foursquare':
                $options->auth_endpoint = 'https://foursquare.com/oauth2/authenticate';
                $options->token_endpoint = 'https://foursquare.com/oauth2/access_token';
            break;

            case 'imgur':
                $options->auth_endpoint = 'https://api.imgur.com/oauth2/authorize';
                $options->token_endpoint = 'https://api.imgur.com/oauth2/token';
            break;

            case 'wordpress':
                $options->auth_endpoint = 'https://public-api.wordpress.com/oauth2/authorize';
                $options->token_endpoint = 'https://public-api.wordpress.com/oauth2/token';
            break;

            case 'spotify':
                $options->auth_endpoint = 'https://accounts.spotify.com/authorize';
                $options->token_endpoint = 'https://accounts.spotify.com/api/token';
            break;

            case 'slack':
                $options->auth_endpoint = 'https://slack.com/oauth/authorize';
                $options->token_endpoint = 'https://slack.com/api/oauth.access';
            break;

            case 'reddit':
                $options->auth_endpoint = 'https://ssl.reddit.com/api/v1/authorize';
                $options->token_endpoint = 'https://ssl.reddit.com/api/v1/access_token';
                $options->scope_separator = ',';
            break;

            case 'twitch':
                $options->auth_endpoint = 'https://api.twitch.tv/kraken/oauth2/authorize';
                $options->token_endpoint = 'https://api.twitch.tv/kraken/oauth2/token';
            break;

            case 'paypal':
                $options->auth_endpoint = 'https://identity.x.com/xidentity/resources/authorize';
                $options->token_endpoint = 'https://identity.x.com/xidentity/oauthtokenservice';
            break;

            case 'pinterest':
                $options->auth_endpoint = 'https://api.pinterest.com/oauth/';
                $options->token_endpoint = 'https://api.pinterest.com/v1/oauth/token';
                $options->scope_separator = ',';
            break;

            case 'stripe':
                $options->auth_endpoint = 'https://connect.stripe.com/oauth/authorize';
                $options->token_endpoint = 'https://connect.stripe.com/oauth/token';
                $options->scope_separator = ',';
            break;

            case 'coinbase':
                $options->auth_endpoint = 'https://www.coinbase.com/oauth/authorize';
                $options->token_endpoint = 'https://www.coinbase.com/oauth/token';
            break;
        }

        return new Oauth2($this->app, $this->app->parseObject($options), $name);
    }

    public function authorize($options) {
        option_require($options, 'provider');
        option_default($options, 'scopes', NULL);
        option_default($options, 'params', (object)array());

        $provider = $this->app->scope->get($options->provider);

        return $provider->authorize($this->app->parseObject($options->scopes), $this->app->parseObject($options->params));
    }

    public function refreshToken($options) {
        option_require($options, 'provider');
        option_default($options, 'refresh_token', NULL);

        $provider = $this->app->scope->get($options->provider);

        return $provider->refreshToken($this->app->parseObject($options->refresh_token));
    }
}
