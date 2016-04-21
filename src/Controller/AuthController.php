<?php

namespace Shokai\Controller;

use Shokai\Application;
use Shokai\Controller\AbstractController;

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
        
        if ($this->app['service.user']->login($state, $code)) {
            return $this->redirectTop();
        }
        return $this->redirectLogout();
    }
    
    public function logoutAction() 
    {
        $this->app['service.user']->logout();
        return $this->redirectLogin();
    }
}