<?php
namespace Quadigital\Service;

abstract class AbstractServiceManager
{
    protected $_services = array();

    public abstract function register($name, $service);

    public abstract function unregister($name);

    public abstract function isRegistered($name);

    public abstract function get($name);

    public abstract function request($name);
}