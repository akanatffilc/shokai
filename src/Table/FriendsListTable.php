<?php

namespace Shokai\Table;

use Shokai\Table\AbstractTable;
use Shokai\Model\User;

class UserTable extends AbstractTable
{
    protected $tableName = 'user';

    protected $modelClass = User::class;

    public function isExistsByEmail($email)
    {
        $qb = $this->getQueryBuilder('id');
        $qb->where('email = :email');
        return $this->isExistsBy($qb, [
            'email'                   => $email
        ]);
    }

    public function findOneByEmail($email)
    {
        $qb = $this->getQueryBuilder('*');
        $qb->where('email = :email');
        return $this->findOneBy($qb, [
            'email'                   => $email
        ]);
    }
}
