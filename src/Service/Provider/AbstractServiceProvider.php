<?php

namespace Shokai\Service\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;

class AbstractServiceProvider implements ServiceProviderInterface
{
    protected $serviceName;
    protected $serviceClass;
    
    public function register(Application $app) 
    {
        $app[$this->serviceName] = $app->share(function ($app) {
            $class = $this->serviceClass;
            $instance = new $class($app);
            $instance->init();
            return $instance;
        });
    }
    
    public function boot(Application $app)
    {
        
    }
}

