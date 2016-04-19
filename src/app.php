<?php

use Shokai\Application as Application;
use Silex\Provider\UrlGeneratorServiceProvider;
use Shokai\Controller\ControllerResolver;
use Shokai\Routing\Generator\UrlGenerator;

$app = new Application;

// Override
$app['resolver'] = $app->share($app->extend('resolver', function ($resolver, $app) {
    return new ControllerResolver($app, $app['logger']);
}));

// Override
$app->register(new UrlGeneratorServiceProvider());
$app['url_generator'] = $app->share(function ($app) {
    $app->flush();
    return new UrlGenerator($app['routes'], $app['request_context'], $app['logger'], $app['session']);
});

return $app;
