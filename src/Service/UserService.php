<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Model\User;
use Shokai\Table\UserTable;
use Shokai\Service\Extension\UserServiceTrait;
use Shokai\Util;

class UserService extends AbstractService
{
    use UserServiceTrait;

    protected $modelName = User::class;
    
    public function __contruct(Application $app) {
        parent::__construct($app);
    }

    public function init() {
        $this->setTable(new UserTable($this->app['db']));
    }
    
    private function create($owner, $token)
    {
        //create user record
        $user_params = [
            User::EMAIL                 => $owner->getEmail(),
            User::FB_ID                 => $owner->getId(),
            User::FB_TOKEN              => $token->getToken(),
            User::FB_TOKEN_EXPIRES_AT   => Util::getDatetimeString($token->getExpires()),
            User::CREATED_AT            => Util::getDatetimeString(),
            User::UPDATED_AT            => Util::getDatetimeString()
        ];
        return $this->createRecord($user_params);
    }
    
    public function login($state, $token, $owner) 
    {
        if (!$this->app['service.auth']->isStateOk($state)) {
            return false;
        }
        
        $user = $this->findOneByEmail($owner->getEmail());
        if (empty($user)) {
            $user = $this->create($owner, $token);
        }
        
        $this->app['service.auth']->login($user, ['state' => $state, 'token' => $token]);       
        $user->setLastLogin(Util::getDatetimeString());
        $this->update($user);
        
        return true;
    }
    
    public function logout() 
    {
        $this->app['service.auth']->logout();
    }
}
