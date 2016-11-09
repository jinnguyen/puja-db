<?php
namespace Puja\Db\Driver\Pdo;
use Puja\Db\Driver\ResultAbstract;
use Puja\Db\Exception;
use Puja\Db\Configure;

class Result extends ResultAbstract
{
    /**
     * @var \PDOStatement
     */
    protected $result;
    protected function validateResultInstance($result)
    {
        if (!($result instanceof \PDOStatement)) {
            throw new Exception('$result must be instance of PDOStatement, given ' . gettype($result));
        }
    }

    public function fetch($fetchType = Configure::FETCH_ASSOC)
    {
        return $this->result->fetch($fetchType);
    }

    public function fetchAll($fetchType = Configure::FETCH_ASSOC)
    {
        return $this->result->fetchAll($fetchType);
    }

    public function fetchColumn($columnNumber = 0)
    {
        return $this->result->fetchColumn($columnNumber);
    }

    public function fetchObject($classNname = null, $ctorArgs = array())
    {
        return $this->result->fetchObject($classNname, $ctorArgs);
    }

    public function rowCount()
    {
        return $this->result->rowCount();
    }

    public function free()
    {
        $this->result->closeCursor();
    }
}