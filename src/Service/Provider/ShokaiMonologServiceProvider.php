<?php

namespace Shokai\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\MonologServiceProvider;

/**
* @package Shokai\Service\Provider
*/
class ShokaiMonologServiceProvider extends MonologServiceProvider implements ServiceProviderInterface
{ 
    public function register(Application $app)
    {
        $app->register(new MonologServiceProvider(), [
            'monolog.logfile' => LOGGER_PATH . sprintf(LOGGER_FILE_NAME, date('Ymd', time())),
            'monolog.level' => (int) LOGGER_LEVEL
        ]);
    }

    public function boot(Application $app)
    {

    }
}

