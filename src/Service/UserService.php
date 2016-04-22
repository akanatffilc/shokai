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
    
    public function login($state, $code) 
    {
        if (!$this->app['service.auth']->isStateOk($state)) {
            return false;
        }
        
        $token  = $this->app['service.oauth.facebook']->getAccessToken($code);
        $owner  = $this->app['service.oauth.facebook']->getResourceOwner($token);
        
        $user = $this->findOneByEmail($owner->getEmail());
        if (empty($user)) {
            $params = [
                'email'                 => $owner->getEmail(),
                'fb_id'                 => $owner->getId(),
                'fb_token'              => $token->getToken(),
                'fb_token_expires_at'   => Util::getDatetimeString($token->getExpires()),
                'created_at'            => Util::getDatetimeString(),
                'updated_at'            => Util::getDatetimeString()
            ];
            
            $user = $this->createRecord($params);
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
