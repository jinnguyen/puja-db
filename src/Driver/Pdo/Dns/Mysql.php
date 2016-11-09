<?php
namespace Puja\Db\Driver\Pdo\Dns;
use Puja\Db\Driver;

class Mysql extends DnsAbstract
{
    protected function buildDns(Driver\ConnectionConfigure $configure)
    {
        $dns = 'mysql:host=' . $configure->getHost() . ';dbname=' . $configure->getDbname();
        if ($configure->getPort()) {
            $dns .= ';port=' . $configure->getPort();
        }

        if ($configure->getSocket()) {
            $dns .= ';unix_socket=' . $configure->getSocket();
        }

        return $dns;
    }
}