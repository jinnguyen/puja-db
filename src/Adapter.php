<?php
namespace Puja\Db;
use Puja\Db\Select;
use Puja\Db\Driver;
use Puja\SqlBuilder\Builder;

class Adapter
{
    protected static $configures;
    protected static $instances;
    protected static $writeAdapterName;
    /**
     * @var \Puja\Db\Driver
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

        if (!array_key_exists('write_adapter_name', $configures) || empty($configures['adapters'])) {
            throw new Exception('The configures must be array(write_adapter_name => <string>,adapters => [...])');
        }

        if (!array_key_exists($configures['write_adapter_name'], $configures['adapters'])) {
            throw new Exception(sprintf('*%s* doesnt exist in $configures[adapters]', $configures['write_adapter_name']));
        }
        
		if (!empty($configures['write_adapter_name'])) {
			self::$writeAdapterName = $configures['write_adapter_name'];
		}
		
        if (empty($configures['DriverClass'])) {
        	$configures['DriverClass'] = Configure::DRIVER_CLASS;
        }
        
        if (empty($configures['DnsClass'])) {
        	$configures['DnsClass'] = Configure::DNS_CLASS;
        }
        
        self::$configures = $configures;
    }

    public static function getInstance($adapterName = null)
    {
        if (empty(self::$configures)) {
            return new self();
        }

        if (empty($adapterName)) {
            $adapterName = current(array_keys(self::$configures['adapters']));
        }

        if (!empty(self::$instances[$adapterName])) {
            return self::$instances[$adapterName];
        }

        if (!array_key_exists($adapterName, self::$configures['adapters'])) {
            throw new Exception($adapterName . ' dosent exist in configured adapters');
        }

        self::$instances[$adapterName] = new self();
        self::$instances[$adapterName]->driver = new Driver(self::$configures['adapters'][$adapterName], self::$configures['DriverClass'], self::$configures['DnsClass']);
        return self::$instances[$adapterName];
    }

    public static function getWriteAdapter()
    {
        return self::getInstance(self::$writeAdapterName);
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
     * @return \Puja\Db\Driver
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
}
