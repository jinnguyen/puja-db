<?php
namespace Puja\Db\Driver;
abstract class ConnectionAbstract
{
    protected $connect;

    /**
     * Creates a Connection instance representing a connection to a database
     * @param ConnectionConfigure $configure
     */
    abstract public function __construct(ConnectionConfigure $configure);

    /**
     * Executes an SQL statement, returning a result set as a ResultAbstract
     * @param $query string
     * @return \Puja\Db\Driver\ResultAbstract
     */
    abstract public function query($query);

    /**
     * Prepares a statement for execution and returns a StatementAbstract
     * @param $query string
     * @return \Puja\Db\Driver\StatementAbstract
     */
    abstract public function prepare($query);

    /**
     * Closes a current opened database connection
     */
    abstract public function close();

    /**
     * Execute an SQL statement and return the number of affected rows
     * @param $query string
     * @return int
     */
    abstract public function execute($query);
    

    /**
     * Returns the ID of the last inserted row or sequence value
     * @return int
     */
    abstract public function lastInsertId();

    /**
     * Fetch extended error information associated with the last operation on the database handle
     * @return string|array
     */
    abstract public function errorInfo();

    /**
     * Fetch the SQLSTATE associated with the last operation on the database handle
     * @return int
     */
    abstract public function errorCode ();

    /**
     * Quotes a string for use in a query.
     * @param $unescaped_string string
     * @return string
     */
    abstract public function quote($unescaped_string);

    /**
     * Initiates a transaction
     */
    abstract public function beginTransaction();

    /**
     * Initiates a transaction
     */
    abstract public function commit();

    /**
     * Rolls back a transaction
     */
    abstract public function rollback();
}