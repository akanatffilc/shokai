<?php

namespace Shokai\Service\Provider;

use Shokai\Service\Provider\AbstractServiceProvider;
use Shokai\Service\FacebookOAuthService;

/**
* @package Shokai\Service\Provider
*/
class FacebookOAuthServiceProvider extends AbstractServiceProvider
{ 
    protected $serviceName = 'service.oauth.facebook';
    protected $serviceClass = FacebookOAuthService::class;
}