<?php
    
namespace Shokai\Service\Provider;

use Shokai\Service\Provider\AbstractServiceProvider;
use Shokai\Service\UserFbProfileService;

/**
* @package Shokai\Service\Provider
*/
class UserFbProfileServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'service.profile.fb.user';
    protected $serviceClass = UserFbProfileService::class;
}