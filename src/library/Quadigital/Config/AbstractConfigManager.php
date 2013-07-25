<?php
/**
 * This file contains an abstract class for managing application configuration.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
namespace Quadigital\Config;

/**
 * An abstract class containing base functions for managing application configuration.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
abstract class AbstractConfigManager
{

    /**
     * Get an item from the configuration manager
     *
     * @param string $configKey The key/name of the configuration item.
     *
     * @return mixed The object stored in the config.
     */
    abstract function get($configKey);

    /**
     * Add an item to the config manager.
     *
     * @param string $configKey The key/name of the configuration item.
     * @param mixed  $config    The item to be stored in the config.
     *
     * @return void
     */
    abstract function add($configKey, $config);

    /**
     * Check whether an item exists in the configuration manager.
     *
     * @param string $configKey The key/name of the configuration item.
     *
     * @return bool Whether an object with the key exists.
     */
    abstract function exists($configKey);

    /**
     * Return a sub-item in the configuration array. It will be an instance of the AbstractConfiguration manager.
     *
     * @param string $configKey The key/name of the configuration item.
     *
     * @return AbstractConfigManager The sub-item in configuration.
     */
    abstract function sub($configKey);

    /**
     * Return the current configuration as an array.
     *
     * @return array Return the specified configuration as an array.
     */
    abstract function asArray();
}