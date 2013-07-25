<?php
namespace Quadigital\Service;

class ServiceManager extends AbstractServiceManager
{

    protected $_services;

    private function __construct()
    {
        $this->_services = array();
    }

    public function register($name, $service)
    {
        if ($this->isRegistered($name)) {
            throw new ServiceException(sprintf('A service with the name %s already exists.', $name));
        }

        $this->_services[$name] = $service;
    }

    public function unregister($name)
    {
        if ($this->isRegistered($name)) {
            unset($this->_services[$name]);
        }
    }

    public function get($name)
    {
        return $this->isRegistered($name) ? $this->_services[$name] : null;
    }

    public function request($name)
    {
        if ($this->isRegistered($name) !== true) {
            throw new ServiceException(sprintf('No service with the name %s already exists.', $name));
        }

        return $this->_services[$name];
    }

    public function isRegistered($name)
    {
        return array_key_exists($name, $this->_services);
    }

    /** @var Holding service manager constantly. */

    private static $_serviceManager;
    private static $_serviceManagerType;

    public static function getServiceMananger()
    {
        if (!isset(self::$_serviceManager)) {
            self::$_serviceManager = new ServiceManager();
        }

        return self::$_serviceManager;
    }

    public static function setType($type)
    {
        self::$_serviceManagerType = $type;
    }
}