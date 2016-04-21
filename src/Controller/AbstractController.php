<?php

namespace Shokai\Controller;

use Shokai\Application;

abstract class AbstractController
{
    protected $app;
    protected $request;

    public function __construct(Application $app) 
    {
        $this->app = $app;
        if(!$this->app->isLoggedin()) {
            return $this->redirectLogin();
        }
    }
    
    public function getGetRequest($param, $default = null) 
    {
        if (empty($this->request)) {
            $this->request = $this->app['request'];
        }
        return $this->request->get($param, $default);
    }
    
    public function redirectTop()
    {
        return $this->app->redirect($this->app->path('site_top'));
    }
    
    public function redirectLogin()
    {
        return $this->app->redirect($this->app->path('login'));
    }
    
    public function redirectLogout()
    {
        return $this->app->redirect($this->app->path('logout'));
    }
}