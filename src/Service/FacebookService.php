<?php

namespace Shokai\Service;

use Shokai\Service\Extension\FacebookTrait;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class FacebookService
{
    use FacebookTrait;
    
    protected static $instance;
    
    public static function init($token) 
    {
        if (empty(self::$instance)) {
                self::$instance = new Facebook([
                'app_id'                => FACEBOOK_CLIENT_ID,
                'app_secret'            => FACEBOOK_CLIENT_SECRET,
                'default_graph_version' => FACEBOOK_GRAPH_API_VERSION
            ]);
        }
        
        self::$instance->setDefaultAccessToken((string) $token);
    }
    
    public static function getGraphUser($fb_id)
    {
        try {
            $fb = self::$instance;
            $query = "/{$fb_id}?fields=id,name,first_name,last_name,gender,relationship_status,birthday,picture{url},link,locale";
            
            //https://developers.facebook.com/docs/graph-api/reference/user  
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get($query);
            
            // Get the response typed as a GraphUser
            return $response->getGraphUser();
            
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
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
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }       
    }
}

