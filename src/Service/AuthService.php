<?php

namespace Shokai\Service;

use Shokai\Service\AbstractService;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthService extends AbstractService
{
    /** @var  Session */
    protected $session;

    protected $sessionStorage;

    public function __construct(Application $app) {
        parent::__construct($app);
    }
    
    public function setSession($session)
    {
        $this->session = $session;
    }

    public function setSessionStorage($sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }

    public function login(AccountImple $model)
    {
        $this->session->set('user', $model);
        $this->sessionStorage->regenerate(true);
    }

    public function logout()
    {
        $this->session->clear();
    }
}