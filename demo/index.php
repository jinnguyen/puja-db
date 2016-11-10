<?php
include '../vendor/autoload.php';
use Puja\Db\Adapter;
use Puja\Db\Table;

$configures = array(
    'write_adapter_name' => 'master',
    'adapters' => array(
        'default' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '123',
            'dbname' => 'fwcms',
            'charset' => 'utf8',
        ),
        'master' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '123',
            'dbname' => 'fwcms',
            'charset' => 'utf8',
        )
    )
);

new Adapter($configures);


$adapter = Table::getAdapter();
/** Prepare testing DB */
/*
$adapter->execute('CREATE TABLE php_category(id INT PRIMARY KEY NOT NULL,name VARCHAR(255) NOT NULL,status INT NOT NULL);');
$adapter->execute("INSERT INTO php_category VALUES(1, 'Jin1', 1),(2, 'Jin2', 0),(3, 'Jin3', 1)");
*/

$num = $adapter->execute('update php_category set name = "JinX" where id = 1');
var_dump($num);

$result = $adapter->query('select * from php_category limit 10');
print_r($result->fetch());


$stmt = $adapter->prepare('select * from php_category where id = :catid and status = :status limit 20');
$stmt->bindValue(':status', 1);
$stmt->bindValue(':catid', 1);
$stmt->execute();
$result = $stmt->fetch();
print_r($result);

$select = $adapter->select()->from('php_category')->where('id = %d', 1)->limit(10);
$result = $adapter->query($select);
print_r($result->fetch());

$table = new Table('php_category');
$result = $table->findByCriteria(array('id' => 2));
print_r($result);

