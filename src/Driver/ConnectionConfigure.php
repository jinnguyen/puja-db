<?php
namespace Puja\Db\Driver;
use Puja\Db\Configure;
use Puja\Db\Exception;

/**
 * Class ConnectionConfigure
 * @package Puja\Db\Driver
 */
class ConnectionConfigure
{
    protected $cfg = array(
        'driver' => null,
        'host' => null,
        'username' => null,
        'password' => null,
        'dbname' => null,
        'charset' => null,
        'port' => null,
        'socket' => null,
        'options' => null,
        'dns' => null,
    );

    public function __construct($data)
    {
        if (empty($data['driver'])) {
            $data['driver'] = Configure::DRIVER_DEFAULT;
        }
        $this->cfg = array_merge($this->cfg, $data);
    }

    public function getDriver()
    {
        if (empty($this->cfg['driver'])) {
            throw new Exception('Driver MUST not empty');
        }
        return $this->cfg['driver'];
    }

    public function getHost()
    {
        return $this->cfg['host'];
    }

    public function getUsername()
    {
        return $this->cfg['username'];
    }

    public function getPassword()
    {
        return $this->cfg['password'];
    }

    public function getDbName()
    {
        return $this->cfg['dbname'];
    }

    public function getCharset()
    {
        return $this->cfg['charset'];
    }

    public function getPort()
    {
        return $this->cfg['port'];
    }

    public function getSocket()
    {
        return $this->cfg['socket'];
    }

    public function getDns()
    {
        if (empty($this->cfg['dns'])) {
            $this->cfg['dns'] = Configure::DNS_DEFAULT;
            return $this->cfg['dns'];
        }

        list($dns, $others) = explode(':', $this->cfg['dns'] . ':');
        return strtolower($dns);
    }

    public function getOptions()
    {
        if (empty($this->cfg['options'])) {
            return [];
        }

        return $this->cfg['options'];
    }
}