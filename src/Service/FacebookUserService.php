<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Service\AbstractService;
use Shokai\Model\User;

class FacebookUserService extends AbstractService
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }
    
    public function fillFriendsList(User $user = null)
    {
        if(empty($user)) {
            $user = $this->app->getUser();
        }
        
        $owner = $this->app['service.facebook']->getResourceOwner($user->getFbToken());
    }
}

