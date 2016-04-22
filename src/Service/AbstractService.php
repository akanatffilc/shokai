<?php

namespace Shokai\Service;

use Shokai\Application;
use Exception;

abstract class AbstractService
{
    protected $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    public function init() 
    {
        
    }
    
    public function createRecord($params = [])
    {
        $record = $this->getModel($params, $this->modelName);
        try {
            $this->table->beginTransaction();
            $this->tableTraitCreate($record);
            $this->table->commit();
        } catch (Exception $e) {
            $this->table->rollback();
            throw $e;
        }
        return $record;
    }
}
