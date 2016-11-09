<?php
namespace Puja\Db\Driver\Pdo\Dns;
use Puja\Db\Driver;

abstract class DnsAbstract
{
    protected $dns;

    public function __construct(Driver\ConnectionConfigure $configure)
    {
        $this->dns = $this->buildDns($configure);
    }
    abstract protected function buildDns(Driver\ConnectionConfigure $configure);
    public function getDns() {
        return $this->dns;
    }
}