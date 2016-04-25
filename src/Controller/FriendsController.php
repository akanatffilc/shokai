<?php

namespace Shokai\Controller;

use Shokai\Application;
use Shokai\Controller\AbstractController;

class FriendsController extends AbstractController 
{
    public function __construct(Application $app) 
    {
        parent::__construct($app);
    }
    
    public function listAction()
    {
        $user = $this->app->getUser();
        $list = $this->app['service.list.friends']->findByUserId($user->getId());
        return $this->app->json($list, 200, ['Access-Control-Allow-Origin' => '*']);
    }
}



