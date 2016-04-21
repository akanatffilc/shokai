<?php

namespace Shokai;

use Silex\Application as SilexApp;

class Application extends SilexApp
{
    use \Silex\Application\TwigTrait;
    use \Silex\Application\MonologTrait;
    use \Silex\Application\UrlGeneratorTrait;
    
    public function isLoggedIn()
    {
        return $this['session']->has('user');
    }

    public function getUser()
    {
        return $this['session']->get('user');
    }

    public function hasState()
    {
        return $this['session']->has('state');
    }

    public function getState()
    {
        return $this['session']->get('state');
    }
}


