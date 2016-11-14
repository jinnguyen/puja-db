<?php
namespace Puja\Db\Driver\Pdo\Dns;
use Puja\Db\Driver;

/**
 * Class Sqlite
 * @package Puja\Db\Driver\Pdo\Dns
 */
class Sqlite extends DnsAbstract
{
    protected function buildDns(Driver\ConnectionConfigure $configure)
    {
        return 'sqlite:' . $configure->getHost();
    }
}