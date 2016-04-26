<?php

namespace Shokai\Service\Extension;

use Shokai\Constants;

trait FacebookTrait 
{
    private static $permissions = [
        Constants::FB_PERMISSIONS_PUBLIC_PROFILE,
        Constants::FB_PERMISSIONS_EMAIL,
        Constants::FB_PERMISSIONS_USER_RELATIONSHIPS,
        Constants::FB_PERMISSIONS_USER_BIRTHDAY,
        Constants::FB_PERMISSIONS_USER_FRIENDS,
    ];
    private static $fields = 'id,name,first_name,last_name,gender,relationship_status,birthday,picture{url},link,locale';
}

