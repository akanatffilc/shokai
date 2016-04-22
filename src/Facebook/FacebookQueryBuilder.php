<?php

namespace Shokai\Facebook;

use Shokai\Application;
use SammyK\FacebookQueryBuilder\FQB;

class FacebookQueryBuilder
{
    protected static $instance;
    
    public static function getInstance(Application $app) {
        $app['service.facebook']->getFacebook()->setDefaultAccessToken((string) $app->getToken());
        self::$instance = new FQB([
            'default_access_token'  => $app->getToken(),
            'default_graph_version' => FACEBOOK_GRAPH_API_VERSION,
            'app_secret'            => FACEBOOK_CLIENT_SECRET,
        ]);
        return self::$instance;
    }
    
    public function getSampleRequest() 
    {
        return $this->instance->node('me')->fields(['id', 'name', 'email']);
    }
}

