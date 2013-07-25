<?php
namespace Quadigital\Module;

abstract class AbstractModule
{

    private $_configArray = null;

    public function getConfigArray()
    {
        $reflectedChild = new \ReflectionClass($this);

        if ($this->_configArray === null && file_exists(dirname($reflectedChild->getFileName()) . DS . 'config' . DS . 'module.config.php')) {
            $this->_configArray = require dirname($reflectedChild->getFileName()) . DS . 'config' . DS . 'module.config.php';
        }

        return $this->_configArray;
    }
}