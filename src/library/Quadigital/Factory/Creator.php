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

abstract class Creator {

    protected abstract function factoryMethod();

    public final function make() {
        return $this->factoryMethod();
    }

    protected final function getServiceManager() {
        return ServiceManager::getServiceMananger();
    }

}