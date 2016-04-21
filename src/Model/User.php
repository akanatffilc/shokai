<?php

namespace Shokai\Model;

use Shokai\Model\AbstractModel;

class User extends AbstractModel
{
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
}
