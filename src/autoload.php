<?php
$loader = require __DIR__.'/../vendor/autoload.php';

$loader->add('Shokai', realpath(__DIR__.'/../src/'));

return $loader;