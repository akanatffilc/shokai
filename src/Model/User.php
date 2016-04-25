<?php

namespace Shokai\Model;

use Shokai\Model\AbstractModel;

class User extends AbstractModel
{
    const EMAIL                 = 'email';
    const FB_ID                 = 'fb_id';
    const FB_TOKEN              = 'fb_token';
    const FB_TOKEN_EXPIRES_AT   = 'fb_token_expires_at';
    
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }
    
    public function getFbId()
    {
        return $this->get('fb_id');
    }
    
    public function getFbToken()
    {
        return $this->get('fb_token');
    }
    
    public function getFbTokenExpiresAt()
    {
        return $this->get('fb_token_expires_at');
    }
    
    public function setLastLogin($datetime)
    {
        $this->set('last_login', $datetime);
        $this->set('updated_at', $datetime);
    }
}
