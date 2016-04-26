<?php

namespace Shokai\Service;

use Shokai\Service\Extension\FacebookTrait;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Shokai\Model\User;
use Shokai\Constants;

class FacebookService
{
    use FacebookTrait;
    
    protected static $isAllMethods;
    protected static $user;
    protected static $instance;
    
    public static function init($obj) 
    {
        if (empty(self::$instance)) {
                self::$instance = new Facebook([
                'app_id'                => FACEBOOK_CLIENT_ID,
                'app_secret'            => FACEBOOK_CLIENT_SECRET,
                'default_graph_version' => FACEBOOK_GRAPH_API_VERSION
            ]);
        }
        $token = "";
        if (obj instanceof User) {
            self::$user = $obj;
            $token = self::$user->getFbToken();
        } else {
            $token = $obj;
        }
        
        self::$instance->setDefaultAccessToken((string) $token);
    }
    
    private static function getFbResponse($query)
    {
        try {
            $fb         = self::$instance;
            $response   = $fb->get($query);
            return $response;          
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
    
    private static function checkUserEmpty()
    {
        if (empty(self::$user)) {
            throw new Exception("User object must be instatiated in order to call method");
        }
    }
    
    /*
     * https://developers.facebook.com/docs/graph-api/reference/user  
     * Returns a `Facebook\FacebookResponse` object
     */
    public static function getGraphUser()
    {
        self::checkUserEmpty();
        $user       = self::$user;
        $fields     = self::$fields;
        $query      = "/{$user->getFbId()}?fields={$fields}";
        $response   = self::getFbResponse($query);
        // Get the response typed as a GraphUser
        return $response->getGraphUser();
    }
    
    public static function getUngrantedPermissions()
    {
        $fields     = self::$fields;
        $query      = "/me/permissions";
        $response   = self::getFbResponse($query);
        $graphEdge  = $response->getGraphEdge();
        
        $ungranted = [];
        foreach($graphEdge->asArray() as $item)
        {
            $permission = $item['permission'];
            $status     = $item['status'];
            if ($status == Constants::FB_PERMISSIONS_STATUS_NG) {
                $ungranted[] = $permission;
            }
        }
        return $ungranted;
    }
    
    /*
     * Check if facebook id parameter passed is a friend of instance facebook user
     * returns true|false
     */
    public static function isFriends($id_b)
    {
        self::checkUserEmpty();
        $user       = self::$user;
        $id_a       = $user->getFbId();
        if ($id_a == $id_b) {
            return false;
        }
        $query      = "/{$id_a}/friends/{$id_b}";
        $response   = self::getFbResponse($query);
        $graphEdge  = $response->getGraphEdge();
        foreach ($graphEdge as $graphNode) {
            return isset($graphNode['id']);
        }     
    }
}

