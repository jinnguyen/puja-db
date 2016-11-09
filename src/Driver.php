<?php
namespace Puja\Db;
use Puja\Db\Driver\ConnectionConfigure;

class Driver
{
    protected $connection;
    protected static $checkDriver;

    public function __construct($config)
    {

        if (empty($config['driver'])) {
            $config['driver'] = 'Pdo';
        }

        $connectCls = 'Puja\\Db\\Driver\\' . $config['driver'] . '\\Connection';
        $resultCls = 'Puja\\Db\\Driver\\' . $config['driver'] . '\\Result';
        $statementCls = 'Puja\\Db\\Driver\\' . $config['driver'] . '\\Statement';
        
        if (null === self::$checkDriver) {
            self::$checkDriver = true;
            if (false == (class_exists($connectCls) && class_exists($resultCls) && class_exists($statementCls))) {
                throw new Exception(sprintf('A driver must have 3 class: %s, %s and %s', $connectCls, $resultCls, $statementCls));
            }
        }


        $this->connection = new $connectCls(new ConnectionConfigure($config));
    }

    /**
     * @return \Puja\Db\Driver\ConnectionAbstract
     */
    public function getConnection()
    {
        return $this->connection;
    }
}