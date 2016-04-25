<?php

namespace Shokai\Table\Extension;

use Shokai\Model\AbstractModel;
use Doctrine\DBAL\Query\QueryBuilder;

trait TableTrait
{
    protected $table;
    
    public function create(AbstractModel $model)
    {
        $id = $this->table->insert($model->getData());
        $model->setId($id);
    }

    public function update(AbstractModel $model)
    {
        return $this->table->update($model->getData(), [ 'id' => $model->getId() ]);
    }

    public function findById($id)
    {
        return $this->table->findById($id);
    }

    public function findAll(QueryBuilder $qb = null)
    {
        return $this->table->findByObject($qb);
    }

    public function findBy(QueryBuilder $qb = null, array $params = [])
    {
        return $this->table->findByObject($qb, $params);
    }

    public function findOneBy(QueryBuilder $qb = null, array $params = [])
    {
        return $this->table->findOneBy($qb, $params);
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function delete($conditions)
    {
        return $this->table->delete($conditions);
    }
}
