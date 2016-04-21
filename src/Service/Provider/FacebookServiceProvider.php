<?php

namespace Shokai\Service\Provider;

use Shokai\Service\Provider\AbstractServiceProvider;
use Shokai\Service\FacebookService;

/**
* @package Shokai\Service\Provider
*/
class FacebookServiceProvider extends AbstractServiceProvider
{ 
    protected $serviceName = 'service.facebook';
    protected $serviceClass = FacebookService::class;
}