<?php

namespace Shokai\Controller;

use Shokai\Application;
use Shokai\Service\FacebookService;
use Shokai\Controller\AbstractController;

class AuthController extends AbstractController 
{
    public function __construct(Application $app) 
    {
        parent::__construct($app);
    }
    
    public function loginAction() 
    {
        $authurl = $this->app['service.oauth.facebook']->getAuthorizationUrl();
        return $this->app->render('auth/login.html.twig',[
            'auth_url' => $authurl
        ]);
    }
    
    public function loginCallbackAction() 
    {
        $this->checkCallbackErrors();
        
        $state          = $this->getGetRequest('state');
        $code           = $this->getGetRequest('code');
        
        $token          = $this->app['service.oauth.facebook']->getAccessToken($code);
        $owner          = $this->app['service.oauth.facebook']->getResourceOwner($token);
        
        FacebookService::init($token->getToken());
        $permissions    = FacebookService::getUngrantedPermissions();
        
        if (empty($permissions)) {
            if ($this->app['service.user']->login($state, $token, $owner)) {
                return $this->app->redirect($this->app->path('init_setup'));
            }
            return $this->redirectLogout();
        } else {
            return $this->redirectLogin(['ungranted' => join(array_filter($permissions), ',')]);
        }
    }
    
    private function checkCallbackErrors()
    {
        $error = $this->getGetRequest('error');
        if (!empty($error)) {
            $error_reason = $this->getGetRequest('error_reason');
            return $this->redirectLogin(['access_denied' => $error_reason]);
        }
    }
    
    private function callbackAction()
    {
        
    }
    
    public function logoutAction() 
    {
        $this->app['service.user']->logout();
        return $this->redirectLogin();
    }
    
    public function fbAuthAction()
    {
        $authurl = $this->app['service.oauth.facebook']->getAuthorizationUrl();
        return $this->app->redirect($authurl);
    }
}