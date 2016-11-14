<?php
namespace Puja\Db;

/**
 * Class Configure
 * @package Puja\Db
 */
class Configure
{
    const DRIVER_DEFAULT = 'Pdo';
    const DNS_DEFAULT = 'mysql';
    
    const DRIVER_DIR = '\\Puja\\Db\\Driver\\';
    const DNS_DIR = '\\Puja\\Db\\Driver\\Pdo\\Dns\\';

    const FETCH_ASSOC = 2;

    /**
     * Specifies that the fetch method shall return each row as an array indexed
     * by column number as returned in the corresponding result set, starting at
     * column 0
     */
    const FETCH_NUM = 3;

    /**
     * Specifies that the fetch method shall return each row as an array indexed
     * by both column name and number as returned in the corresponding result set,
     * starting at column 0.
     */
    const FETCH_BOTH = 4;

    /**
     * Specifies that the fetch method shall return each row as an object with
     * property names that correspond to the column names returned in the result
     * set.
     */
    const FETCH_OBJ = 5;

    /**
     * Represents a boolean data type.
     * @link http://php.net/manual/en/pdo.constants.php
     */
    const PARAM_BOOL = 5;

    /**
     * Represents the SQL NULL data type.
     * @link http://php.net/manual/en/pdo.constants.php
     */
    const PARAM_NULL = 0;

    /**
     * Represents the SQL INTEGER data type.
     * @link http://php.net/manual/en/pdo.constants.php
     */
    const PARAM_INT = 1;

    /**
     * Represents the SQL CHAR, VARCHAR, or other string data type.
     * @link http://php.net/manual/en/pdo.constants.php
     */
    const PARAM_STR = 2;

    /**
     * Represents the SQL large object data type.
     * @link http://php.net/manual/en/pdo.constants.php
     */
    const PARAM_LOB = 3;

    protected $configures = array(
        'write_adapter_name' => null,
    	'DriverDir' => '',
    	'DnsDir' => '',
        'adapters' => array()
    );

    public function __construct($configures = array())
    {
        if (empty($configures['adapters'])) {
            throw new Exception('The configures array must have key *adapters* => [...]');
        }

        if (empty($configures['write_adapter_name'])) {
            $configures['write_adapter_name'] = current(array_keys($configures['adapters']));
        }


        if (!array_key_exists($configures['write_adapter_name'], $configures['adapters'])) {
            throw new Exception(sprintf('*%s* doesnt exist in $configures[adapters]', $configures['write_adapter_name']));
        }

        if (empty($configures['DriverDir'])) {
            $configures['DriverDir'] = self::DRIVER_DIR;
        }

        if (empty($configures['DnsDir'])) {
            $configures['DnsDir'] = self::DNS_DIR;
        }

        $this->configures = array_merge($this->configures, $configures);
    }

    public function getWriteAdapterName()
    {
        return $this->configures['write_adapter_name'];
    }

    public function getDriverDir()
    {
        return $this->configures['DriverDir'];
    }

    public function getDnsDir()
    {
        return $this->configures['DnsDir'];
    }

    public function getAdapters()
    {
        return $this->configures['adapters'];
    }
}