<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Test\Reflection;

/**
 * Class Reflection
 * @package Quadigital\Test\Reflection
 */
class Reflection {

    public static function getProperty($classInstance, $propertyName) {
        $reflectedConnector = new \ReflectionClass($classInstance);
        /** @var \ReflectionProperty $defaultOptions */
        $reflectedField = $reflectedConnector->getProperty($propertyName);
        $reflectedField->setAccessible(true);
        return $reflectedField->getValue($classInstance);
    }

}