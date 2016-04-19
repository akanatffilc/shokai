<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Silex\Application;

$app['routes'] = $app->extend('routes', function (RouteCollection $routes, Application $app) {
    $loader     = new YamlFileLoader(new FileLocator( '/app/config'));   
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);
    $routes->setSchemes(['https']);
    return $routes;
});

$app->after(function (Request $request) {
    /**
     * Redirectしたときに、flashBag含めてSessionが引き継がれない問題に対する対策
     * （SessionストレージがmemcachedかPDOかつ、nginx+php-fpm環境で発生するらしい）
     * @see https://github.com/symfony/symfony/issues/6417#issuecomment-12513993
     * @see https://bugs.php.net/bug.php?id=63963
     */
    if (function_exists('fastcgi_finish_request') && $request->hasSession()) {
        $request->getSession()->save();
    }
});