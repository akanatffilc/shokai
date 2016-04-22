<?php

namespace Shokai\Table;

use Shokai\Table\AbstractTable;
use Shokai\Model\FriendsList;

class FriendsListTable extends AbstractTable
{
    protected $tableName = 'friends_list';
    protected $modelClass = FriendsList::class;    
}
