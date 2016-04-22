<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Util;
use Shokai\Model\User;
use Shokai\Model\FriendsList;
use Shokai\Table\FriendsListTable;
use Shokai\Service\FacebookService;
use Shokai\Service\Extension\FriendsListServiceTrait;

class FriendsListService extends AbstractService
{
    use FriendsListServiceTrait;

    protected $modelName = FriendsList::class;
    
    public function __contruct(Application $app) {
        parent::__construct($app);
    }

    public function init() {
        $this->setTable(new FriendsListTable($this->app['db']));
    }
    
    public function create($params) {
        $this->createRecord($params);
    }

    public function createFriendsList(User $user)
    {
        FacebookService::init($user->getFbToken());
        $users = $this->app['service.user']->findAll();
        foreach($users as $u)
        {
            $id_a = $user->getFbId();
            $id_b = $u->getFbId();
            
            $isFriends = FacebookService::isFriends($this->app, $id_a, $id_b);
            if ($isFriends) {
                $params = [
                    'user_id'               => $user->getId(),
                    'fb_id'                 => $id_b,
                    'created_at'            => Util::getDatetimeString(),
                    'updated_at'            => Util::getDatetimeString()
                ];
                $this->create($params);
            }
        }
    }
}
