# puja-db
Puja\Db is an adapter that allow your application access to a databases

Install:
<pre>composer require jinnguyen/puja-db</pre>

Usage:
<pre>
require_once 'path/to/vendor/autoload.php';
use Puja\Db\Adapter;
use Puja\Db\Table;

// Load db configures
$configures = array(
    'write_adapter_name' => 'master',
    'adapters' => array(
        'default' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '123',
            'dbname' => 'fwcms',
            'charset' => 'utf8'
        ),
        'master' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '123',
            'dbname' => 'fwcms',
            'charset' => 'utf8'
        )
    )
);
//Load configures to Adapter, just need load 1 time
new Adapter($configures);



</pre>

<strong>Create Adapters</strong>
<pre>
// create default adapter
$adapter = Table::getAdapter('default'); // get  adapter from $configure[adapters][default]

or $adapter = Table::getAdapter(); // get the first adapter from $configure[adapters]

// create write adapter
$adapter = Table::getAdapter('write'); // get  adapter from $configure[adapters][write]

or $adapter = Table::getWriteAdapter() // get adapter from $configure[adapters][*write_adapter_name*]
</pre>

<strong>Execute</strong><br />
<em>Execute an SQL statement and return the number of affected rows</em>
<pre>
$num = $adapter->execute('select * from *table* limit 20');
var_dump($num);
</pre>

<strong>Query</strong><br />
<em>Executes an SQL statement, returning a result set as a result resource</em>
<pre>
$result = $adapter->query('select * from *table* limit 20');
print_r($result->fetch());
</pre>

<strong>Prepare</strong><br />
<em>Prepares a statement for execution and returns a Statement</em>
<pre>
$stmt = $adapter->prepare('select * from *table* where id = :id and status = :status limit 20');
$stmt->bindValue(':status', 1);
$stmt->bindValue(':id', 10);
$stmt->execute();
print_r($stmt->fetch());
</pre>

<strong>Use SQL builder</strong>
<pre>
// Visit https://github.com/jinnguyen/puja-sqlbuilder for more detail
// Build query
$select = $adapter->select()->from('*table*')->where('id = %d', 1)->limit(10);

$result = $adapter->query($select);
print_r($result->fetch());
</pre>

<strong>From table object</strong>
<pre>
$table = new Table('<table>');
$result = $table->findByCriteria(array('id' => 1));
print_r($result);
</pre>