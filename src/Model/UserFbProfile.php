<?php

namespace Shokai\Model;

use Shokai\Model\AbstractModel;

class UserFbProfile extends AbstractModel
{
    const USER_ID               = 'user_id';
    const NAME                  = 'name';
    const FIRST_NAME            = 'first_name';
    const LAST_NAME             = 'last_name';
    const GENDER                = 'gender';
    const RELATIONSHIP_STATUS   = 'relationship_status';
    const BIRTHDAY              = 'birthday';
    const PROFILE_IMAGE_URL     = 'profile_image_url';
    const LINK                  = 'link';
    const LOCALE                = 'locale';
    
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }
}
