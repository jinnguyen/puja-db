<?php
namespace Puja\Db\Driver;

/**
 * Class ResultAbstract
 * @package Puja\Db\Driver
 */
abstract class ResultAbstract
{
    protected $result;
    public function __construct($result)
    {
        $this->validateResultInstance($result);
        $this->result = $result;
    }

    abstract protected function validateResultInstance($result);

    /**
     * Fetch a result row as an associative, a numeric array, or both
     * @param int $fetchType
     * @return array
     */
    abstract public function fetch($fetchType = Configure::FETCH_ASSOC);

    /**
     * Fetches all result rows and returns the result set as an associative array, a numeric array, or both
     * @param int $fetchType
     * @return array
     */
    abstract public function fetchAll($fetchType = Configure::FETCH_ASSOC);

    /**
     * Returns a single column from the next row of a result set
     * @param int $columnNumber
     * @return mixed
     */
    abstract public function fetchColumn($columnNumber = 0);

    /**
     * Returns the current row of a result set as an object
     * @param null $classNname
     * @param array $ctorArgs
     * @return stdClass|object an object with string properties that corresponds to the fetched
     * row or null if there are no more rows in resultset.
     */
    abstract public function fetchObject($classNname = null, $ctorArgs = array()); // Fetches the next row and returns it as an object.

    /**
     * Gets the number of rows in a result
     * @return int
     */
    abstract public function rowCount();

    /**
     * Frees the memory associated with a result
     */
    abstract public function free();
}
