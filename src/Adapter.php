<?php
namespace Puja\Db;
use Puja\Db\Select;
use Puja\Db\Driver;
use Puja\SqlBuilder\Builder;

/**
 * Class Adapter
 * @package Puja\Db
 */
class Adapter
{
    /**
     * @var \Puja\Db\Configure
     */
    protected static $configures;
    protected static $instances;
    /**
     * @var \Puja\Db\Driver\Driver
     */
    protected $driver;

    public function __construct($configures = array())
    {
        if (!empty($configures)) {
            $this->loadConfigures($configures);
        }

    }

    public function loadConfigures($configures)
    {
        if (null !== self::$configures) {
            throw new Exception('The configures are already loaded, no need to reload again');
        }

        self::$configures = new Configure($configures);
    }

    public static function getInstance($adapterName = null)
    {
        if (empty(self::$configures)) {
            throw new Exception('Adapter are not configured yet, pls call *new Adapter($configures)*');
        }

        $adapters = self::$configures->getAdapters();
        if (empty($adapterName)) {
            $adapterName = current(array_keys($adapters));
        }

        if (!empty(self::$instances[$adapterName])) {
            return self::$instances[$adapterName];
        }

        if (!array_key_exists($adapterName, $adapters)) {
            throw new Exception($adapterName . ' doesnt exist in configured adapters');
        }

        self::$instances[$adapterName] = new self();
        self::$instances[$adapterName]->driver = new Driver\Driver(
            $adapters[$adapterName],
            self::$configures->getDriverDir(),
            self::$configures->getDnsDir()
        );
        return self::$instances[$adapterName];
    }

    public static function getWriteInstance()
    {
        return self::getInstance(self::$configures->getWriteAdapterName());
    }

    /**
     * @param $query string|\Puja\SqlBuilder\Builder
     * @return int
     */
    public function execute($query)
    {
        if ($query instanceof Builder) {
            $query = $query->getQuery();
        }
        return $this->driver->getConnection()->execute($query);

    }

    /**
     * @param $query string|\Puja\SqlBuilder\Builder
     * @return Driver\ResultAbstract
     */
    public function query($query)
    {
        if ($query instanceof Builder) {
            $query = $query->getQuery();
        }
        return $this->driver->getConnection()->query($query);
    }

    /**
     * @param $query string|\Puja\SqlBuilder\Builder
     * @return Driver\StatementAbstract
     */
    public function prepare($query)
    {
        if ($query instanceof Builder) {
            $query = $query->getQuery();
        }
        return $this->driver->getConnection()->prepare($query);
    }

    /**
     * @return \Puja\Db\Driver\Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return Builder
     */
    public function select()
    {
        $select = new Builder();
        return $select->reset()->select();
    }

    /**
     * @param $table
     * @param array $insertFields
     * @return int
     */
    public function insert($table, array $insertFields, $ignore = false)
    {
        $select = new Builder();
        if ($ignore) {
            $query = $select->reset()->insertIgnore($table, $insertFields);
        } else {
            $query = $select->reset()->insert($table, $insertFields);
        }

        return $this->driver->getConnection()->execute($query->getQuery());

    }

    /**
     * @param $table
     * @param array $updateFields
     * @param $cond
     * @return int
     */
    public function update($table, array $updateFields, $cond)
    {
        $select = new Builder();
        $query = $select->reset()->update($table, $updateFields)->where($cond);
        return $this->driver->getConnection()->execute($query->getQuery());
    }

    /**
     * @param $table
     * @param $cond
     * @return int
     * @throws \Puja\SqlBuilder\Exception
     */
    public function delete($table, $cond)
    {
        $select = new Builder();
        $query = $select->reset()->delete($table)->where($cond);
        return $this->driver->getConnection()->execute($query->getQuery());
    }


    public function replace($table, array $replaceFields)
    {
        $select = new Builder();
        $query = $select->reset()->replace($table, $replaceFields);
        return $this->driver->getConnection()->execute($query->getQuery());
    }

    public function truncate($table)
    {
        $select = new Builder();
        $query = $select->reset()->truncate($table);
        return $this->driver->getConnection()->execute($query->getQuery());
    }
}
