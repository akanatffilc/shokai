<?php

namespace Shokai\Table;
use Shokai\Table\AbstractTable;
use Shokai\Model\UserFbProfile;

class UserFbProfileTable extends AbstractTable
{
    protected $tableName = 'user_fb_profile';

    protected $modelClass = UserFbProfile::class;
    
    public function isExistsByUserId($user_id)
    {
        $qb = $this->getQueryBuilder('id');
        $qb->where('user_id = :user_id');
        var_dump($qb);
        return $this->isExistsBy($qb, ['user_id' => $user_id]);
    }
}
