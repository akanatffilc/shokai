<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Model\User;
use Shokai\Table\UserTable;
use Shokai\Service\Extension\UserServiceTrait;
use Shokai\Util;
use Exception;

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

    public function create($params = [])
    {
        $user = $this->getModel($params, $this->modelName);
        try {
            $this->table->beginTransaction();
            $this->tableTraitCreate($user);
            $this->table->commit();
        } catch (Exception $e) {
            $this->table->rollback();
            throw $e;
        }
        return $user;
    }
    
    public function login($state, $code) 
    {
        if ($this->app->hasState() && (empty($state) || ($state !== $this->app->getState()))) {
            $this->app['service.auth']->removeSession('state');
            return false;
        }        
        
        $token  = $this->app['service.facebook']->getAccessToken($code);
        $owner  = $this->app['service.facebook']->getResourceOwner($token);
        
        $user = $this->findOneByEmail($owner->getEmail());
        if (empty($user)) {
            $params = [
                'email'                 => $owner->getEmail(),
                'fb_id'                 => $owner->getId(),
                'fb_token'              => $token->getToken(),
                'fb_token_expires_at'   => Util::getDatetimeString($token->getExpires())            
            ];
            
            $user = $this->create($params);
        }
        $this->app['service.auth']->login($state, $user);
        $user->set('last_login', Util::getDatetimeString());
        $this->update($user);
        
        return true;
    }
    
    public function logout() 
    {
        $this->app['service.auth']->logout();
    }
}
