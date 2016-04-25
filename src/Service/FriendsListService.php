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
    
    public function findByUserId()
    {
        
    }

    public function createFriendsList(User $user)
    {
        FacebookService::init($user->getFbToken());
        $users = $this->app['service.user']->findAll();
        foreach($users as $u)
        {
            $a_user_id = $user->getId();
            $a_fb_id = $user->getFbId();
            $b_user_id = $u->getId();
            $b_fb_id = $u->getFbId();
            
            $isFriend = $this->isExistsByUserIds($a_user_id, $b_user_id);
            $canAdd = ($isFriend) ? false : FacebookService::isFriends($a_fb_id, $b_fb_id);
            if ($canAdd) {
                $params = [
                    'user_id_a'     => $a_user_id,
                    'user_id_b'     => $b_user_id,
                    'created_at'    => Util::getDatetimeString(),
                    'updated_at'    => Util::getDatetimeString()
                ];
                $this->create($params);
            }
        }
    }
    
    public function checkDuplicate($a_id, $b_id)
    {
        
    }
}
