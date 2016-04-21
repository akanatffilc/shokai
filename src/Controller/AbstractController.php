<?php

namespace Shokai\Controller;

use Shokai\Application;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{
    protected $app;
    protected $request;

    public function __construct(Application $app) 
    {
        $this->app = $app;
    }
    
    public function getGetRequest($param, $default = null) 
    {
        if (empty($this->request)) {
            $this->request = $this->app['request'];
        }
        return $this->request->get($param, $default);
    }
}