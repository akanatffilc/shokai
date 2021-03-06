<?php

namespace Shokai\Service\Extension;

use Shokai\Table\Extension\TableTrait;
use Shokai\Model\Extension\ModelTrait;
 
trait FriendsListServiceTrait
{
    use TableTrait {
        create as tableTraitCreate;
        update as tableTraitUpdate;
    }
    use ModelTrait;  
    
    public function findByUserId($user_id)
    {
        return $this->table->findByUserId($user_id);
    }
    
    public function isExistsByUserIds($id_a, $id_b)
    {
        return $this->table->isExistsByUserIds($id_a, $id_b);
    }
}