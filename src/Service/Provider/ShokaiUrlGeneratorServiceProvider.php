<?php

namespace Shokai\Service\Provider;

use Silex\Application;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\ServiceProviderInterface;
use Shokai\Routing\Generator\UrlGenerator;


/**
* @package Shokai\Service\Provider
*/
class ShokaiUrlGeneratorServiceProvider extends UrlGeneratorServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app->register(new UrlGeneratorServiceProvider());
        $app['url_generator'] = $app->share(function ($app) {
            $app->flush();
            return new UrlGenerator($app['routes'], $app['request_context'], $app['logger'], $app['session']);
        });
    }

    public function boot(Application $app)
    {

    }
}

    
    

