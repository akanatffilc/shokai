<?php

use Shokai\Application as Application;
use Shokai\Controller\ControllerResolver;

$app = new Application;

// Override
$app['resolver'] = $app->share($app->extend('resolver', function ($resolver, $app) {
    return new ControllerResolver($app, $app['logger']);
}));

return $app;
