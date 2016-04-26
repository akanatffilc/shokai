<?php

namespace Shokai\Table;

use Shokai\Table\AbstractTable;
use Shokai\Model\FriendsList;

class FriendsListTable extends AbstractTable
{
    protected $tableName = 'friends_list';
    protected $modelClass = FriendsList::class; 
    
    public function findByUserId($user_id)
    {
        $qb = $this->getQueryBuilder('*');
        $qb->where('user_id_a = :user_id or user_id_b = :user_id');
        return $this->findByObject($qb, ['user_id' => $user_id]);
    }
    
    public function isExistsByUserIds($id_a, $id_b)
    {
        $qb = $this->getQueryBuilder('id');
        $qb->where('(user_id_a = :id_a and user_id_b = :id_b) or (user_id_a = :id_b and user_id_b = :id_a)');
        return $this->isExistsBy($qb, ['id_a' => $id_a, 'id_b' => $id_b]);
    }
}
