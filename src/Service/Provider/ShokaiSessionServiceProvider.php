<?php

namespace Shokai\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\SessionServiceProvider;

/**
* @package Shokai\Service\Provider
*/
class ShokaiSessionServiceProvider extends SessionServiceProvider implements ServiceProviderInterface
{ 
    public function register(Application $app)
    {
        $app->register(new SessionServiceProvider(), [
            'session.storage.options' => [
                'name'            => SESSION_STORAGE_OPTION_NAME,
                'cookie_secure'   => true,
                'cookie_httponly' => true,
            ],
        ]);
    }

    public function boot(Application $app)
    {

    }
}

