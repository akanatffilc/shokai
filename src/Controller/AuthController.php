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
        // if callback returns errors, request params are passed back to login and 'auth_type'=>'rerequest'
        // must be passed to getAuthorizationUrl
        $errors     = $this->getCallbackErrors();
        $ungranted  = $this->getUngrantedQueries();
        $params     = [];
        if (!empty($errors) || !(empty($ungranted))) {
            $params = ['auth_type'=>'rerequest'];
        }
        $authurl = $this->app['service.oauth.facebook']->getAuthorizationUrl($params);
        $viewData = [
            'auth_url'  => $authurl,
            'ungranted' => $ungranted
        ];
        return $this->app->render('auth/login.html.twig', $viewData);
    }
    
    public function loginCallbackAction() 
    {
        $errors = $this->getCallbackErrors();
        if (!empty($errors)) {
            return $this->redirectLogin($errors);
        }
        
        $state          = $this->getGetRequest('state');
        $code           = $this->getGetRequest('code');
        
        $token          = $this->app['service.oauth.facebook']->getAccessToken($code);
        $owner          = $this->app['service.oauth.facebook']->getResourceOwner($token);
        
        FacebookService::init($token->getToken());
        $permissions    = FacebookService::getUngrantedPermissions();
        
        if (empty($permissions)) {
            if ($this->app['service.user']->login($state, $token, $owner)) {
                return $this->redirectAfterLogin();
            }
            return $this->redirectLogout();
        } else {
            return $this->redirectLogin(['ungranted' => join(array_filter($permissions), ',')]);
        }
    }
    
    private function getCallbackErrors()
    {
        $error = $this->getGetRequest('error');
        if (!empty($error)) {
            $error_reason = $this->getGetRequest('error_reason');
            return ['error' => $error, 'error_reason' => $error_reason];
        }
        return [];
    }
    
    private function getUngrantedQueries()
    {
        $ungranted = $this->getGetRequestToArray('ungranted');
        return empty($ungranted) ? [] : $ungranted;
    }
    
    private function redirectAfterLogin() 
    {
        $isCompletedInit = $this->app->getUser()->getIsCompletedInit();
        if ($isCompletedInit) {
            return $this->redirectTop();
        } else {
            return $this->redirect('init_setup');
        }
    }
    
    public function logoutAction() 
    {
        $this->app['service.user']->logout();
        return $this->redirectLogin();
    }
}