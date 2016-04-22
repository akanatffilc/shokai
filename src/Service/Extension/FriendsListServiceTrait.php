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
}