<?php
namespace Puja\Db\Driver\Pdo;
use Puja\Db\Driver;
use Puja\Db\Exception;
use Puja\Db\Configure;

class Connection extends Driver\ConnectionAbstract
{
    public function __construct(Driver\ConnectionConfigure $configure, $DnsClass = Configure::DNS_DEFAULT)
    {
        $dnsCls = $DnsClass . ucfirst($configure->getDns());
        if (!class_exists($dnsCls)) {
            throw new Exception('Your dns is not defined');
        }
        $dnsObj = new $dnsCls($configure);
        $this->connect = new \PDO($dnsObj->getDns(), $configure->getUsername(), $configure->getPassword(), $configure->getOptions());
    }

    public function query($query)
    {
        try {
            $result = $this->connect->query($query);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if (!($result instanceof \PDOStatement))
        {
            $error = $this->connect->errorInfo();
            throw new Exception($error[2]);
        }

        return new Result($result, $query);

    }

    public function prepare($query)
    {
        try {
            $stmt = $this->connect->prepare($query);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if (!($stmt instanceof \PDOStatement))
        {
            $error = $this->connect->errorInfo();
            throw new Exception($error[2]);
        }

        return new Statement($stmt, $query);
    }

    public function close()
    {

    }

    public function execute($query)
    {
        try {
            $result = $this->connect->query($query);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if (!($result instanceof \PDOStatement))
        {
            $error = $this->connect->errorInfo();
            throw new Exception($error[2]);
        }

        $count = $result->rowCount();
        $result->closeCursor();
        return $count;
    }

    public function lastInsertId()
    {
        return $this->connect->lastInsertId();
    }

    public function errorInfo()
    {
        return $this->connect->errorInfo();
    }

    public function errorCode ()
    {
        return $this->connect->errorCode();
    }

    public function quote($unescaped_string, $paramType = Configure::PARAM_STR)
    {
        return $this->connect->quote($unescaped_string, $paramType);
    }

    public function beginTransaction()
    {
        $this->connect->beginTransaction();
    }

    public function commit()
    {
        $this->connect->commit();
    }

    public function rollback()
    {
        $this->connect->rollBack();
    }
}