<?php

namespace Shokai\Model;

use Shokai\Model\AbstractModel;

class User extends AbstractModel
{
    const EMAIL                 = 'email';
    const FB_ID                 = 'fb_id';
    const FB_TOKEN              = 'fb_token';
    const FB_TOKEN_EXPIRES_AT   = 'fb_token_expires_at';
    const IS_COMPLETED_INIT     = 'is_completed_init';
    const LAST_LOGIN            = 'last_login';
    
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }
    
    public function getEmail()
    {
        return $this->get(self::EMAIL);
    }
    
    public function getFbId()
    {
        return $this->get(self::FB_ID);
    }
    
    public function getFbToken()
    {
        return $this->get(self::FB_TOKEN);
    }
    
    public function getFbTokenExpiresAt()
    {
        return $this->get(self::FB_TOKEN_EXPIRES_AT);
    }
    
    public function getIsCompletedInit()
    {
        return $this->get(self::IS_COMPLETED_INIT);
    }
    
    public function setLastLogin($datetime)
    {
        $this->set(self::LAST_LOGIN, $datetime);
        $this->set(self::UPDATED_AT, $datetime);
    }
}
