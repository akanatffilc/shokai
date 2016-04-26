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
    
    public function redirectTop(array $params = [])
    {
        return $this->app->redirect($this->app->path('site_top', $params));
    }
    
    public function redirectLogin(array $params = [])
    {
        return $this->app->redirect($this->app->path('login', $params));
    }
    
    public function redirectLogout(array $params = [])
    {
        return $this->app->redirect($this->app->path('logout', $params));
    }
}