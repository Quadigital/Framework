<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Factory;

use Quadigital\Service\ServiceManager;

class LoadFactories {

    private $_factories = null;

    public function __construct(array $factories) {
        $this->_factories = $factories;
    }

    public function make() {
        /** @var array $factory */
        foreach ($this->_factories as $factoryName => $factorySettings) {
            $factory = null;

            if (!isset($factorySettings['Class'])) {
                trigger_error(sprintf('%s does not have a factory class set.', $factoryName), E_USER_WARNING);
            }

            $class = $factorySettings['Class'];
            $storage = isset($factorySettings['Storage']) ? $factorySettings['Storage'] : 'Service';
            $parameters = isset($factorySettings['Parameters']) ? $factorySettings['Parameters'] : array();
            $parameterObjects = array();

            if (count($parameters) > 0) {
                foreach ($parameters as $parameterName => $parameter) {
                    $object = null;

                    $parameterStorage = isset($parameter['Storage']) ? $parameter['Storage'] : 'Config';

                    if (!isset($parameter['Name'])) {
                        trigger_error(sprintf('%s does not have a parameter name set.', $parameterName), E_USER_WARNING);
                    }

                    $storageName = $parameter['Name'];

                    if ($parameterStorage === 'Service') {
                        // TODO
                    } else if ($parameterStorage === 'Config') {
                        $configManager = $this->getServiceManager()->request('Config');
                        $parameterObjects[$parameterName] = $configManager->get($storageName);
                    }
                }
            }

            if(count($parameterObjects) == 0)
                $factory = new $class;
            else {
                $reflectedClass = new \ReflectionClass($class);
                $factory = $reflectedClass->newInstanceArgs($parameterObjects);
            }

            $result = $factory->make();


            if ($storage === 'Service') {
                $serviceManager = $this->getServiceManager();
                $serviceManager->register($factoryName, $result);
            } else if ($storage === 'Config') {
                $configManager = $this->getServiceManager()->request('Config');
                $configManager->add($result, $factoryName);
            }
        }
    }

    protected final function getServiceManager() {
        return ServiceManager::getServiceMananger();
    }
}