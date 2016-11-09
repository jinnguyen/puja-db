<?php
namespace Puja\Db\Driver;
use Puja\Db\Configure;
abstract class StatementAbstract
{


	protected $statement;
	protected $fetchMode;
	protected $sql;
	public function __construct($statement = null, $sql = null)
	{
		$this->statement = $statement;
		$this->sql = $sql;
		$this->fetchMode = Configure::FETCH_ASSOC;
	}

	public function getSql()
	{
		return $this->sql;
	}

	/**
	 * Binds a parameter to the specified variable name
	 * @param $parameter
	 * @param $variable
	 * @param int $dataType
	 */
	abstract public function bindParam($parameter, &$variable, $dataType = Configure::PARAM_STR);
	/**
	 * Binds a value to a parameter
	 * @param $parameter
	 * @param $variable
	 * @param int $dataType
	 */
	abstract public function bindValue($parameter, $variable, $dataType = Configure::PARAM_STR);


	/**
	 * Closes the cursor, enabling the statement to be executed again.
	 */
	abstract public function closeCursor();

	/**
	 * Returns the number of columns in the result set
	 */
	abstract public function columnCount();

	/**
	 * Fetch the SQLSTATE associated with the last operation on the statement handle
	 * @return int
	 */
	abstract public function errorCode();

	/**
	 * Fetch extended error information associated with the last operation on the statement handle
	 * @return array
	 */
	abstract public function errorInfo();

	/**
	 * Executes a prepared statement
	 */
	abstract public function execute($parameters = array());

	/**
	 * Fetch a result row as an associative, a numeric array, or both
	 * @param int $fetchType
	 * @return array
	 */
	abstract public function fetch($fetchType = null);

	/**
	 * Fetches all result rows and returns the result set as an associative array, a numeric array, or both
	 * @param int $fetchType
	 * @return array
	 */
	abstract public function fetchAll($fetchType = null);

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
	abstract public function fetchObject($classNname = null, $ctorArgs = array());

	/**
	 * Retrieve a statement attribute
	 * @param $attr
	 * @return mixed
	 */
	abstract public function getAttribute($attr);

	/**
	 * Returns the number of rows affected by the last SQL statement
	 * @return int
	 */
	abstract public function rowCount();

	/**
	 * Set a statement attribute
	 * @param $attr
	 * @param $mode
	 */
	abstract public function setAttribute($attr, $mode);

	/**
	 * Set the default fetch mode for this statement
	 * @param $fetchMode
	 */
	abstract public function setFetchMode($fetchMode);

}