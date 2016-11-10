<?php
namespace Puja\Db\Driver\Pdo\Dns;
use Puja\Db\Driver;

class Sqlite extends DnsAbstract
{
    protected function buildDns(Driver\ConnectionConfigure $configure)
    {
        return 'sqlite:' . $configure->getHost();
    }
}