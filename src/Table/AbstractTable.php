<?php

namespace Shokai\Table;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use Shokai\Util;
use Shokai\Table\Extension\TableTrait;
use Shokai\Model\Extension\ModelTrait;

abstract class AbstractTable
{
    use TableTrait {
        create as tableTraitCreate;
        update as tableTraitUpdate;
    }
    use ModelTrait;
    
    /** @var Connection */
    public $db;

    protected $tableName;

    protected $modelClass;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function setModelClass($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setFetchModeForModel($stmt)
    {
        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->modelClass);
    }

    /**
     * getQueryBuilder
     * @param type $field
     * @return QueryBuilder
     */
    public function getQueryBuilder($field = '*')
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select($field)
            ->from($this->tableName, substr($this->tableName, 0, 1));
        return $qb;
    }
    
    /**
     * findByObject
     * @param string|QueryBuilder $sql
     * @param array $params
     * @return Statement
     */
    public function findByObject($obj = null, array $params = [], array $options = [])
    {
        //Object is string or QueryBuilder so if QueryBuilder is null, instantiate
        if (empty($obj)) {
            $obj = $obj ?: $this->getQueryBuilder();
        } 
        $statement = $this->db->prepare($obj);
        if(empty($params)) {
            $statement->execute();
        } else {
            $statement->execute($params);
        }
        
        //set  options
        $o = array_merge([
                'fetchForModel' => true,
                'fetch'         => 'all',
            ],
            $options);
        if ($o['fetchForModel']) {
            $this->setFetchModeForModel($statement);
        }
        
        switch ($o['fetch']) {
            case 'all'      :
                return $statement->fetchAll();
            case 'one'      :
                return $statement->fetch();
            case 'column'   :
                return $statement->fetchColumn(0);
            default :
                throw new Exception("AbstractTable->findByObject(): undeclared case for fetch option");
        }
    }

    public function findOneBy($qb, $param) 
    {
        return $this->findByObject($qb, $param, ['fetch' => 'one']);
    }
    
    public function findById($id)
    {
        $sql = sprintf('SELECT * FROM `%s` WHERE id = ?', $this->tableName);
        return $this->findByObject($sql, [$id], ['fetchForModel' => false, 'fetch' => 'one']);
    }

    public function count()
    {
        $sql = sprintf('SELECT COUNT(*) FROM `%s`', $this->tableName);
        return $this->findByObject($sql, [], ['fetchForModel' => false, 'fetch' => 'column']);
    }

    public function countBy(array $conditions = [], $countField = '*')
    {
        $qb = $this->db->createQueryBuilder();
        /* @var $qb QueryBuilder */
        $qb->select('count('.$countField.')')
           ->from($this->tableName, substr($this->tableName, 0, 1));
        $wheres = [];
        foreach ($conditions as $key => $value) {
            $wheres[] = "{$key} = :{$key}";
        }
        $qb->where(implode(' AND ', $wheres))
           ->setParameters($conditions);
        $stmt = $qb->execute();
        return $stmt->fetchColumn();
    }

    public function insertAll(array $records)
    {
        $this->db->beginTransaction();
        try{
            foreach ($records as $record) {
                $this->db->insert($this->tableName, $record);
            }
            $this->db->commit();
        } catch(Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function getColumnNames()
    {
        $colmuns = $this->db->getSchemaManager()->listTableColumns($this->tableName);
        $names = array();
        foreach ($colmuns as $column) {
            $names[] = $column->getName();
        }
        return $names;
    }

    public function isExistsBy(QueryBuilder $qb, array $params = [])
    {
        return (bool) $this->findByObject($qb, $params, ['fetchForModel' => false, 'fetch' => 'column']);
    }

    public function isExistsById($id)
    {
        $sql = sprintf('SELECT 1 FROM `%s` WHERE id = ?', $this->tableName);
        return (bool) $this->findByObject($sql, array($id), ['fetchForModel' => false, 'fetch' => 'column']);
    }

    public function insert($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = Util::getDatetimeString();
        }
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = Util::getDatetimeString();
        }

        if ($this->db->insert($this->tableName, $data)) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function update($data, $conditions)
    {
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = Util::getDatetimeString();
        }
        if ($this->db->update($this->tableName, $data, $conditions)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($conditions)
    {
        if ($this->db->delete($this->tableName, $conditions)) {
            return true;
        } else {
            return false;
        }
    }

    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    public function commit()
    {
        $this->db->commit();
    }

    public function rollback()
    {
        $this->db->rollback();
    }

    public function foundRows()
    {
        $sql = 'SELECT FOUND_ROWS()';
        return (int) $this->findByObject($sql, [], ['fetchForModel' => false, 'fetch' => 'column']);
    }
}
