<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Service\AbstractService;
use League\OAuth2\Client\Provider\Facebook;

class FacebookService extends AbstractService 
{
    protected $facebook_provider;
    
    public function __construct(Application $app) {
        parent::__construct($app);
        $this->facebook_provider = new Facebook([
            'clientId'          => FACEBOOK_CLIENT_ID,
            'clientSecret'      => FACEBOOK_CLIENT_SECRET,
            'redirectUri'       => $this->app->url('login_callback'),
            'graphApiVersion'   => FACEBOOK_GRAPH_API_VERSION,
        ]);
    }
    
    public function getAuthorizationUrl() {
        return $this->facebook_provider->getAuthorizationUrl([
            'scope' => $this->facebook_provider->getDefaultScopes()
        ]);
    }
    
    public function getAccessToken($code) {
        return $this->facebook_provider->getAccessToken('authorization_code', [
            'code' => $code
        ]);
    }
    
    public function getResourceOwner($token) {
        return $this->facebook_provider->getResourceOwner($token);
    }
}

