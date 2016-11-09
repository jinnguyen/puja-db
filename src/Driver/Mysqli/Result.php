<?php
namespace Puja\Db\Driver\Mysqli;
use Puja\Db\Driver\ResultAbstract;
use Puja\Db\Exception;
use Puja\Db\Configure;

class Result extends ResultAbstract
{
    /** @var  \mysqli_result */
    protected $result;
    protected $resultTypeMapping = array(
        Configure::FETCH_ASSOC => MYSQLI_ASSOC,
        Configure::FETCH_NUM => MYSQLI_NUM,
        Configure::FETCH_BOTH => MYSQLI_BOTH,
    );

    public function fetch($fetchType = Configure::FETCH_ASSOC)
    {
        return $this->result->fetch_array($this->resultTypeMapping[$fetchType]);
    }

    public function fetchColumn($columnNumber = 0)
    {
        $result = $this->result->fetch_row();
        return $result[$columnNumber];
    }

    public function fetchObject($classNname = null, $ctorArgs = array())
    {
        return $this->result->fetch_object($classNname, $ctorArgs);
    }
    
    public function fetchAll($fetchType = Configure::FETCH_ASSOC)
    {
        return $this->result->fetch_all($this->resultTypeMapping[$fetchType]);
    }

    public function rowCount()
    {
        return $this->result->num_rows;
    }

    public function free()
    {
        return $this->result->free();
    }

    protected function validateResultInstance($result)
    {
        if (false == $result instanceof \mysqli_result) {
            throw new Exception('$result must be instance of mysqli_result');
        }
    }
}