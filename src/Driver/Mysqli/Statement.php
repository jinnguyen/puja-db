<?php
namespace Puja\Db\Driver\Mysqli;
use Puja\Db\Driver\StatementAbstract;
use Puja\Db\Exception;
use Puja\Db\Configure;

/**
 * Class Statement
 * @package Puja\Db\Driver\Mysqli
 */
class Statement extends StatementAbstract
{
    /** @var  \Puja\Db\Driver\Mysqli\Result*/
    protected $result;
    /** @var  \mysqli */
    protected $connection;
    protected $bindValues = array();

    protected $paramMapping = array(
        Configure::PARAM_STR => 's',
        Configure::PARAM_INT => 'd',
        Configure::PARAM_LOB => 'b',
    );

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }


    public function bindParam($parameter, &$variable, $dataType = Configure::PARAM_STR)
    {
        
    }
    
    public function bindValue($parameter, $value, $dataType = Configure::PARAM_STR)
    {
        $this->bindValues[$parameter . '[MYSQLI_PARAM_SEPERATE]' . $dataType] = $value;
    }

    public function closeCursor()
    {
        if (null === $this->statement) {
            return;
        }
        $this->statement->close();
    }

    public function columnCount()
    {
        if (null === $this->statement) {
            return;
        }
        return $this->statement->field_count;
    }

    public function errorCode()
    {
        if (null === $this->statement) {
            return;
        }
        return $this->statement->errno;
    }

    public function errorInfo()
    {
        if (null === $this->statement) {
            return;
        }
        return $this->statement->error;
    }

    public function execute($parameters = array())
    {
        if ($parameters) {
            $this->bindValues = $parameters;
        }
        $this->bindMysqliStatement();

        $this->statement->execute();

        $this->result = new Result($this->statement->get_result());

    }

    public function fetch($fetchType = null)
    {
        if (null === $fetchType) {
            $fetchType = $this->fetchMode;
        }
        return $this->result->fetch($fetchType);
    }

    public function fetchColumn($columnNumber = 0)
    {
        return $this->result->fetchColumn($columnNumber);
    }

    public function fetchObject($classNname = null, $ctorArgs = array())
    {
        return $this->result->fetchObject($classNname, $ctorArgs);
    }

    public function fetchAll($fetchType = null)
    {
        if (null === $fetchType) {
            $fetchType = $this->fetchMode;
        }
        return $this->result->fetchAll($fetchType);
    }

    public function getAttribute($attr)
    {
        return $this->statement->attr_get($attr);
    }

    public function rowCount()
    {
        if (null === $this->statement) {
            return;
        }
        return $this->statement->affected_rows;
    }

    public function setAttribute($attr, $mode)
    {
        if (null === $this->statement) {
            return;
        }
        $this->statement->attr_set($attr, $mode);
    }

    public function setFetchMode($fetchMode)
    {
        $this->fetchMode = $fetchMode;
    }

    protected function bindMysqliStatement()
    {
        if (empty($this->bindValues)) {
            return;
        }

        $type = '';
        $args = array();
        $replacementArrays = array();

        foreach ($this->bindValues as $key => &$value) {
            list($paramName, $paramType) = explode('[MYSQLI_PARAM_SEPERATE]', $key . '[MYSQLI_PARAM_SEPERATE]');

            if (empty($paramType)) {
                $paramType = Configure::PARAM_STR;
            }

            if (substr($paramName, 0, 1) == ':') {
                $replacementArrays[$paramName] = $value;
            } else {
                $type .= $this->paramMapping[$paramType];
                $args[$paramName] = &$value;
            }

        }

        if ($replacementArrays) {
            $sql = str_replace(array_keys($replacementArrays), $replacementArrays, $this->sql);
        }

        $this->statement = $this->connection->prepare($sql);

        if ($args) {
            ksort($args);
            array_unshift($args, $type);
            call_user_func_array(array($this->statement, 'bind_param'), $args);
        }
    }
}