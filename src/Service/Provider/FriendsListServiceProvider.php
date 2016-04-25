<?php
    
namespace Shokai\Service\Provider;

use Shokai\Service\Provider\AbstractServiceProvider;
use Shokai\Service\FriendsListService;

/**
* @package Shokai\Service\Provider
*/
class FriendsListServiceProvider extends AbstractServiceProvider
{
    public $serviceName = 'service.list.friends';
    protected $serviceClass = FriendsListService::class;
}