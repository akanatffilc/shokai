<?php
    
namespace Shokai\Service\Provider;

use Shokai\Service\Provider\AbstractServiceProvider;
use Shokai\Service\UserService;

/**
* @package Shokai\Service\Provider
*/
class UserServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'service.user';
    protected $serviceClass = UserService::class;
}