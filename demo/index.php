<?php
include '../vendor/autoload.php';
use Puja\Db\Adapter;
use Puja\Db\Table;

$config = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '123',
    'dbname' => 'fwcms',
    'charset' => 'utf8'
);

$master = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '123',
    'dbname' => 'fwcms',
    'charset' => 'utf8'
);

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

new Adapter($configures);


$adapter = Table::getAdapter();

$num = $adapter->execute('select * from php_category limit 20');
var_dump($num);

$result = $adapter->query('select content_id from php_content limit 0,10');
print_r($result->fetch());


$stmt = $adapter->prepare('select * from php_category where category_id = :catid and status = :status limit 20');
$stmt->bindValue(':status', 1);
$stmt->bindValue(':catid', 50);
$stmt->execute();
$result = $stmt->fetch();

$select = $adapter->select()->from('php_category')->where('category_id = %d', 1)->limit(10);
$result = $adapter->query($select);
print_r($result->fetch());

$table = new Table('php_category');
$result = $table->findByCriteria(array('category_id' => 2));
print_r($result);

