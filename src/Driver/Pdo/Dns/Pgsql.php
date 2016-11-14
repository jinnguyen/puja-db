<?php
namespace Puja\Db\Driver\Pdo\Dns;
use Puja\Db\Driver;
/**
 * Class Pgsql
 * @package Puja\Db\Driver\Pdo\Dns
 */
class Pgsql extends DnsAbstract
{
	protected function buildDns(Driver\ConnectionConfigure $configure)
	{
		$dns = 'pgsql:host=' . $configure->getHost() . ';dbname=' . $configure->getDbName();
		if ($configure->getPort()) {
			$dns .= ';port=' . $configure->getPort();
		}
		return $dns;
	}
}