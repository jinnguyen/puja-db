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
        $result = $this->connect->query($query);
        if ($result === false) {
            throw new Exception(print_r($this->connect->errorInfo(), true));
        }
        return new Result($result, $query);

    }

    public function prepare($query)
    {
        return new Statement($this->connect->prepare($query), $query);
    }

    public function close()
    {

    }

    public function execute($query)
    {
        $stmt = $this->connect->query($query);
        $count = $stmt->rowCount();
        $stmt->closeCursor();
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