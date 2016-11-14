<?php
namespace Puja\Db;

use Puja\Db\Adapter;
use Puja\Db\Select;

/**
 * Class Table
 * @package Puja\Db
 */
class Table
{
    protected $tableName;

    public function __construct($tblName = null)
    {
        if (!empty($tblName)) {
            $this->tableName = $tblName;
        }
    }

    public function getTableName()
    {
        return $this->tableName;
    }
    
    public static function getAdapter($name = null)
    {
        return Adapter::getInstance($name);
    }

    public static function getWriteAdapter()
    {
        return Adapter::getWriteInstance();
    }

    public function findOneByCriteria($criteria)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from($this->tableName)->where($criteria);
        $result = $adapter->query($select);
        return $result->fetch();
    }

    public function findByCriteria($criteria)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from($this->tableName)->where($criteria);
        $result = $adapter->query($select);
        return $result->fetchAll();
    }

    public function updateByCriteria(array $updateFields, $criteria)
    {
        return self::getWriteAdapter()->update($this->tableName, $updateFields, $criteria);
    }

    public function insert(array $insertFields, $ignore = false)
    {
        return self::getWriteAdapter()->insert($this->tableName, $insertFields, $ignore);
    }

    public function deleteByCriteria($criteria)
    {
        return self::getWriteAdapter()->delete($this->tableName, $criteria);
    }

    public function truncate()
    {
        return self::getWriteAdapter()->truncate($this->tableName);
    }

    public function replace(array $replaceFields)
    {
        return self::getWriteAdapter()->replace($this->tableName, $replaceFields);
    }

}