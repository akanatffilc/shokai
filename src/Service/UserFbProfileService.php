<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Model\UserFbProfile;
use Shokai\Table\UserFbProfileTable;
use Shokai\Service\Extension\UserFbProfileServiceTrait;
use Shokai\Util;

class UserFbProfileService extends AbstractService
{
    use UserFbProfileServiceTrait;

    protected $modelName = UserFbProfile::class;
    
    public function __contruct(Application $app) {
        parent::__construct($app);
    }

    public function init() {
        $this->setTable(new UserFbProfileTable($this->app['db']));
    }
    
    public function createUserFbProfile($user)
    {
        if (!$this->isExistsByUserId($user->getId()))
        {
            //create user_fb_profile record
            FacebookService::init($user->getFbToken());
            $fb_user = FacebookService::getGraphUser($user->getFbId());
            $user_fb_profile_params = [
                UserFbProfile::USER_ID              => $user->getId(),
                UserFbProfile::NAME                 => $fb_user->getName(),
                UserFbProfile::FIRST_NAME           => $fb_user->getFirstName(),
                UserFbProfile::LAST_NAME            => $fb_user->getLastName(),
                UserFbProfile::GENDER               => $fb_user->getGender(),
                UserFbProfile::RELATIONSHIP_STATUS  => $fb_user->getField(UserFbProfile::RELATIONSHIP_STATUS),
                UserFbProfile::BIRTHDAY             => Util::dateTimeToString($fb_user->getBirthday()),
                UserFbProfile::PROFILE_IMAGE_URL    => $fb_user->getField('picture')->getUrl(),
                UserFbProfile::LINK                 => $fb_user->getLink(),
                UserFbProfile::LOCALE               => $fb_user->getField(UserFbProfile::LOCALE),
                UserFbProfile::CREATED_AT           => Util::getDatetimeString(),
                UserFbProfile::UPDATED_AT           => Util::getDatetimeString(),
            ];
            $this->app['service.profile.fb.user']->createRecord($user_fb_profile_params);
        }  
    }  
}
