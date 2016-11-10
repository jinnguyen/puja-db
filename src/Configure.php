<?php
namespace Puja\Db;

class Configure
{
    const DRIVER_DEFAULT = 'Pdo';
    const DNS_DEFAULT = 'mysql';
    
    const DRIVER_CLASS = '\\Puja\\Db\\Driver\\';
    const DNS_CLASS = '\\Puja\\Db\\Driver\\Pdo\\Dns\\';

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
    	'DriverClass' => '',
    	'DnsClass' => '',
        'adapters' => array()
    );
}