<?php
namespace Puja\Db\Driver\Pdo\Dns;
use Puja\Db\Driver;

/**
 * Class Mysql
 * @package Puja\Db\Driver\Pdo\Dns
 */
class Mysql extends DnsAbstract
{
    protected function buildDns(Driver\ConnectionConfigure $configure)
    {
        $dns = 'mysql:host=' . $configure->getHost() . ';dbname=' . $configure->getDbName();
        if ($configure->getPort()) {
            $dns .= ';port=' . $configure->getPort();
        }

        if ($configure->getSocket()) {
            $dns .= ';unix_socket=' . $configure->getSocket();
        }

        return $dns;
    }
}