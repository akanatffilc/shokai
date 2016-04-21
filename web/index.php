<?php

ini_set('display_errors', 1);

require_once __DIR__.'/../src/autoload.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/settings.php';
require __DIR__.'/../src/service.php';
require __DIR__.'/../src/controllers.php';

$app['debug'] = true;

$app->run();