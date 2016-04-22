<?php

namespace Shokai\Facebook;

use Shokai\Application;
use SammyK\FacebookQueryBuilder\FQB;

class FacebookQueryBuilder
{
    protected static $instance;
    
    public static function getInstance(Application $app) {
        self::$instance = new FQB([
            'default_access_token'  => 'CAACEdEose0cBACYcKxuxjQNTIWLZAUmIoEt9n2BgOXmP6OoiQWCrj4tDEEc9hG3Pks8w8mvl6qq0c39o8sCM8ETAQCymXhnDM2ZCRhwqklJfirNJBddniwvWU010WHXJyoj0YxIXR2yZAkOPxo6VR5aHTLz4c23CgYtZC3IQq7kQy7jqAzKXlgzs01MinsYk4iU3CTmJlwZDZD',
            'default_graph_version' => FACEBOOK_GRAPH_API_VERSION,
            'app_secret'            => FACEBOOK_CLIENT_SECRET,
        ]);
        return self::$instance;
    }
}

