<?php

namespace Shokai\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Shokai\Event\EventSubscriber\AuthEventSubscriber;

/**
* @package Shokai\Service\Provider
*/
class ShokaiEventSubscriberProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app->extend('dispatcher', function ($dispatcher, $app) {
            $dispatcher->addSubscriber(new AuthEventSubscriber($app));
            return $dispatcher;
        });
        
    }

    public function boot(Application $app)
    {

    }
}

    
    

