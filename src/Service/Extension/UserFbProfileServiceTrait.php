<?php

namespace Shokai\Service\Extension;

use Shokai\Table\Extension\TableTrait;
use Shokai\Model\Extension\ModelTrait;
 
trait UserFbProfileServiceTrait
{
    use TableTrait {
        create as tableTraitCreate;
        update as tableTraitUpdate;
    }
    use ModelTrait;  
    
    public function isExistsByUserId($user_id)
    {
        return $this->table->isExistsByUserId($user_id);
    }
}