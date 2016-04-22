<?php

namespace Shokai\Service;

use Shokai\Service\Extension\FacebookTrait;
use Facebook\Facebook;

class FacebookService
{
    use FacebookTrait;
    
    protected static $instance;
    
    public static function getInstance($token) 
    {
        if (empty(self::$instance)) {
                self::$instance = new Facebook([
                'app_id'                => FACEBOOK_CLIENT_ID,
                'app_secret'            => FACEBOOK_CLIENT_SECRET,
                'default_graph_version' => FACEBOOK_GRAPH_API_VERSION
            ]);
        }
        self::$instance->setDefaultAccessToken((string) $token);
        return self::$instance;
    }
    
    public static function isFriends($id_a, $id_b)
    {
        if ($id_a == $id_b) {
            return false;
        }
        try {
            $fb = self::$instance;
            $url = "/{$id_a}/friends/{$id_b}";
            $response = $fb->get($url);
            $graphEdge = $response->getGraphEdge();
            foreach ($graphEdge as $graphNode) {
                return isset($graphNode['id']);
            }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }        
    }
}

