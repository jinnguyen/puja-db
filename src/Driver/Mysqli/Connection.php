<?php
namespace Puja\Db\Driver\Mysqli;
use Puja\Db\Driver;
use Puja\Db\Exception;
use Puja\Db\Configure;

class Connection extends Driver\ConnectionAbstract
{
    public function __construct(Driver\ConnectionConfigure $configure, $DnsClass = Configure::DNS_CLASS)
    {
        $this->connect = new \mysqli(
            $configure->getHost(),
            $configure->getUsername(),
            $configure->getPassword(),
            $configure->getDbName(),
            $configure->getSocket()
        );
        if ($configure->getOptions()) {
            foreach ($configure->getOptions() as $opt => $val) {
                $this->connect->set_opt($opt, $val);
            }
        }
        
        if ($this->connect->connect_error) {
            throw new Exception('Cannot connect ' . $configure->getHost());
        }

        if ($configure->getCharset()) {
            $this->connect->set_charset($configure->getCharset());
        }
    }

    public function execute($query)
    {
        $this->connect->query($query);
        return $this->connect->affected_rows;
    }

    public function query($query)
    {
        return new Result($this->connect->query($query));
    }

    public function prepare($query)
    {
        $stmt = new Statement(null, $query);
        $stmt->setConnection($this->connect);
        return $stmt;
    }

    public function close()
    {
        return $this->connect->close();
    }

    public function lastInsertId()
    {
        return $this->connect->insert_id;
    }
    public function errorInfo()
    {
        return $this->connect->error;
    }
    public function errorCode()
    {
        return $this->connect->errno;
    }
    public function quote($unescaped_string)
    {
        return $this->connect->escape_string($unescaped_string);
    }
    public function beginTransaction()
    {
        $this->connect->begin_transaction();
    }
    public function commit()
    {
        $this->connect->commit();
    }
    public function rollback()
    {
        $this->connect->rollback();
    }
}