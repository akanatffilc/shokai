<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Service\AbstractService;
use Shokai\Service\Extension\FacebookTrait;
use Facebook\Facebook;

class FacebookService extends AbstractService 
{
    use FacebookTrait;
    
    protected $facebook;
    
    public function __construct(Application $app) 
    {
        parent::__construct($app);
        $this->facebook = new Facebook([
            'app_id'                => FACEBOOK_CLIENT_ID,
            'app_secret'            => FACEBOOK_CLIENT_SECRET,
            'default_graph_version' => FACEBOOK_GRAPH_API_VERSION
        ]);
    }
    
    public function getFacebook() 
    {
        return $this->facebook;
    }
}

