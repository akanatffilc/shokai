<?php

namespace Shokai\Service;

use Shokai\Application;
use Shokai\Model\User;
use Shokai\Model\Extension\ModelTrait;
use Shokai\Table\Extension\TableTrait;
use Shokai\Table\UserTable;
use Exception;

class UserService extends AbstractService
{
    use TableTrait {
        create as tableTraitCreate;
        update as tableTraitUpdate;
    }
    use ModelTrait;

    protected $modelName = User::class;
    
    public function __contruct(Application $app) {
        parent::__construct($app);
    }

    public function init() {
        $this->setTable(new UserTable($this->app['db']));
    }

    public function create($params = [])
    {
        $user = $this->getModel($params, $this->modelName);
        try {
            $this->table->beginTransaction();
            $this->tableTraitCreate($user);
            $this->table->commit();
        } catch (Exception $e) {
            $this->table->rollback();
            throw $e;
        }
        return $user->getId();
    }
}
