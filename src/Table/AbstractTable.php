<?php

namespace Shokai\Table;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use Shokai\Util;

abstract class AbstractTable
{
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

    public function findBy(QueryBuilder $qb = null, array $params = [])
    {
        $qb = $qb ?: $this->getQueryBuilder();
        $stmt = $this->db->prepare($qb);
        $stmt->execute($params);
        $this->setFetchModeForModel($stmt);
        return $stmt->fetchAll();
    }

    public function findBySql($sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $this->setFetchModeForModel($stmt);
        return $stmt->fetchAll();
    }

    public function findAsAssocBySql($sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findOneBy(QueryBuilder $qb = null, array $params = [])
    {
        $qb = $qb ?: $this->getQueryBuilder();
        $stmt = $this->db->prepare($qb);
        $stmt->execute($params);
        $this->setFetchModeForModel($stmt);
        return $stmt->fetch();
    }

    public function findRowsBy(QueryBuilder $qb, array $params = [])
    {
        $stmt = $this->db->prepare($qb->getSql());
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $sql = sprintf('SELECT * FROM `%s` WHERE id = ?', $this->tableName);
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $this->setFetchModeForModel($stmt);
        return $stmt->fetch();
    }

    public function findByCode($code)
    {
        $sql = sprintf('SELECT * FROM `%s` WHERE code = ?', $this->tableName);
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$code]);
        $this->setFetchModeForModel($stmt);
        return $stmt->fetch();
    }

    public function count()
    {
        $sql = sprintf('SELECT COUNT(*) FROM `%s`', $this->tableName);
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn(0);
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

    public function buildQuery(QueryBuilder $qb, array $conditions = [])
    {
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
        $stmt = $this->db->prepare($qb);
        $stmt->execute($params);
        return (bool)$stmt->fetchColumn(0);
    }

    public function isExistsById($id)
    {
        $sql = sprintf('SELECT 1 FROM `%s` WHERE id = ?', $this->tableName);
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return (bool)$stmt->fetchColumn(0);
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
        $stmt = $this->db->query('SELECT FOUND_ROWS()');
        return (int)$stmt->fetchColumn(0);
    }
}
