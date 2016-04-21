<?php

namespace Shokai\Service\Extension;

use Shokai\Table\Extension\TableTrait;
use Shokai\Model\Extension\ModelTrait;
 
trait UserServiceTrait
{
    use TableTrait {
        create as tableTraitCreate;
        update as tableTraitUpdate;
    }
    use ModelTrait;
    
    public function isExistsByEmail($email)
    {
        return $this->table->isExistsByEmail($email);
    }   
    
    public function findOneByEmail($email)
    {
        return $this->table->findOneByEmail($email);
    }    
}