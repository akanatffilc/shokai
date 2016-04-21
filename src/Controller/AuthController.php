<?php

namespace Shokai\Controller;

use Shokai\Application;
use Shokai\Controller\AbstractController;
use Shokai\Util;

class AuthController extends AbstractController 
{
    public function __construct(Application $app) 
    {
        parent::__construct($app);
    }
    
    public function loginAction() 
    {

        $authurl = $this->app['service.facebook']->getAuthorizationUrl();
        return $this->app->render('auth/login.html.twig',[
            'auth_url' => $authurl
        ]);
    }
    
    public function loginCallbackAction() 
    {
        $state  = $this->getGetRequest('state');
        $code   = $this->getGetRequest('code');
        
        $token  = $this->app['service.facebook']->getAccessToken($code);
        $owner  = $this->app['service.facebook']->getResourceOwner($token);
        
        $params = [
            'email'                 => $owner->getEmail(),
            'fb_id'                 => $owner->getId(),
            'fb_token'              => $token->getToken(),
            'fb_token_expires_at'   => Util::getDatetimeString($token->getExpires())            
        ];

        $this->app['service.user']->create($params);
        return $this->app->render('main/index.html.twig',[
            
        ]);
    }
    
    public function logoutAction() 
    {
       return $this->app->render('auth/logout.html.twig');
    }
}