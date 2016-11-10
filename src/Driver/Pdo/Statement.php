<?php
namespace Puja\Db\Driver\Pdo;

use Puja\Db\Driver\StatementAbstract;
use Puja\Db\Exception;
use Puja\Db\Configure;

class Statement extends StatementAbstract
{
    /**
     * @var \PDOStatement
     */
    protected $statement;

    public function bindParam($parameter, &$variable, $dataType = Configure::PARAM_STR)
    {
        $this->statement->bindParam($parameter, $variable, $dataType);
    }

    public function bindValue($parameter, $variable, $dataType = Configure::PARAM_STR)
    {
        $this->statement->bindValue($parameter, $variable, $dataType);
    }

    public function closeCursor()
    {
        $this->statement->closeCursor();
    }

    public function columnCount()
    {
        return $this->statement->columnCount();
    }

    public function errorCode()
    {
        return $this->statement->errorCode();
    }

    public function errorInfo()
    {
        return $this->statement->errorInfo();
    }

    public function execute($parameters = array())
    {
        if (empty($parameters)) {
            $parameters = null;
        }
        try {
            $executed = $this->statement->execute($parameters);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if (false === $executed) {
            $error = $this->statement->errorInfo();
            throw new Exception($error[2]);
        }


    }

    public function fetch($fetchType = null)
    {
        if (null === $fetchType) {
            $fetchType = $this->fetchMode;
        }
        
        return $this->statement->fetch($fetchType);
    }

    public function fetchAll($fetchType = null)
    {
        if (null === $fetchType) {
            $fetchType = $this->fetchMode;
        }
        return $this->statement->fetchAll($fetchType);
    }

    public function fetchColumn($columnNumber = 0)
    {
        return $this->statement->fetchColumn($columnNumber);
    }

    public function fetchObject($classNname = null, $ctorArgs = array())
    {
        return $this->statement->fetchObject($classNname, $ctorArgs);
    }

    public function getAttribute($attr)
    {
        return $this->statement->getAttribute($attr);
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    public function setAttribute($attr, $mode)
    {
        return $this->statement->setAttribute($attr, $mode);
    }

    public function setFetchMode($fetchMode)
    {
        $this->statement->setFetchMode($fetchMode);
    }
}