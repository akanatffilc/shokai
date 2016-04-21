<?php
    
namespace Shokai\Service\Provider;

use Shokai\Service\Provider\AbstractServiceProvider;
use Shokai\Service\AuthService;

/**
* @package Shokai\Service\Provider
*/
class AuthServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'service.auth';
    protected $serviceClass = AuthService::class;
}