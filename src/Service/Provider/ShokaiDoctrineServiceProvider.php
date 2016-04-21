<?php

namespace Shokai\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;
use Doctrine\DBAL\Configuration;

/**
* @package Shokai\Service\Provider
*/
class ShokaiDoctrineServiceProvider extends DoctrineServiceProvider implements ServiceProviderInterface
{ 
    public function register(Application $app)
    {
        $app->register(new DoctrineServiceProvider(), [
            'db.options' => [
                'driver'    => 'pdo_mysql',
                'host'      => 'localhost',
                'dbname'    => DB_NAME,
                'user'      => 'root',
                'password'  => '',
                'charset'   => 'utf8',
            ],
            'db.config' => new Configuration([
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ])
        ]);
    }

    public function boot(Application $app)
    {

    }
}

