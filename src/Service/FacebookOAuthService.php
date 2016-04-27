<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Service\AbstractService;
use Shokai\Service\Extension\FacebookTrait;
use League\OAuth2\Client\Provider\Facebook;
use Symfony\Component\Security\Acl\Exception\Exception;

class FacebookOAuthService extends AbstractService 
{
    use FacebookTrait;
    
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
    
    public function getFacebookOAuthProvider() {
        return $this->facebook_provider;
    }
    
    public function getAuthorizationUrl(array $params = []) {
        $options = array_merge([
            'scope' => self::$permissions
        ],$params);
        return $this->facebook_provider->getAuthorizationUrl($options);
    }
    
    public function getAccessToken($code) {
        return $this->facebook_provider->getAccessToken('authorization_code', [
            'code' => $code
        ]);
    }
    
    public function getResourceOwner($token = null) {
        if (empty($token) && !$this->app->hasToken()) {
            throw new Exception("unable to access token");
        } else if (empty($token)) {
            $token = $this->app->getToken();
        }
        return $this->facebook_provider->getResourceOwner($token);
    }
}

