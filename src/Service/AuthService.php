<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Service\AbstractService;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthService extends AbstractService
{
    /** @var  Session */
    protected $session;

    protected $sessionStorage;

    public function __construct(Application $app) 
    {
        parent::__construct($app);
    }
    
    public function init() 
    {
        $this->setSession($this->app['session']);
        $this->setSessionStorage($this->app['session.storage']);
    }
    
    public function setSession($session)
    {
        $this->session = $session;
    }

    public function setSessionStorage($sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }
    
    public function removeSession($key) 
    {
        if($this->session->has($key)) {
            $this->session->remove($key);
        }
    }

    public function login($model, $fb_info = [])
    {
        $this->session->set('state', $fb_info['state']);
        $this->session->set('token', $fb_info['token']);
        $this->session->set('user', $model);
        $this->sessionStorage->regenerate(true);
    }

    public function logout()
    {
        $this->session->clear();
    }
    
    public function isStateOk($state) 
    {
        if ($this->app->hasState() && (empty($state) || ($state !== $this->app->getState()))) {
            $this->app['service.auth']->removeSession('state');
            return false;
        }    
        return true;
    }
}