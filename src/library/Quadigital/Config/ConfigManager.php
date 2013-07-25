<?php
/**
 * This file contains a class for managing application configuration.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
namespace Quadigital\Config;

use Quadigital\Config\Exception\ConfigException;

/**
 * An simple class containing base functionality for managing application configuration.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class ConfigManager extends AbstractConfigManager
{

    /**
     * Holds an array of the current configuration.
     *
     * @var array An array of configuration.
     */
    private $_config;

    private $_defaultDefaultSettings = 'Quadigital/Config/data/defaults.php';

    /**
     * Grabs the default configuration array (if it exists 'data/defaults.php') and merges it with the
     * configuration array passed.
     *
     * @param array        &$configArray Array containing the configuration.
     * @param string|array $defaults     Array containing the default configuration or and
     *                                   array containing configuration.
     * @param bool         $useDefaults  Whether the default configuration should be added
     */
    function __construct(&$configArray = array(), $defaults = null,  $useDefaults = true) {
        if ($defaults === null) {
            $defaults = LIBRARY_DIR . $this->_defaultDefaultSettings;
        }

        if ($useDefaults && is_array($defaults)) {
            $this->_config = array_replace_recursive($defaults, $configArray);
        } else if ($useDefaults && is_string($defaults) && file_exists($defaults)) {
            /** @noinspection PhpIncludeInspection */
            $this->_config = array_replace_recursive(include $defaults, $configArray);
        } else {
            $this->_config = $configArray;
        }
    }

    /**
     * Add an item to the config manager.
     *
     * @param mixed  $config    The item to be stored in the config.
     * @param string $configKey The key/name of the configuration item.
     *
     * @return void
     */
    function add($config, $configKey = null)
    {
        if ($configKey !== null) {
            if ($this->exists($configKey) && is_array($config)) {
                $this->_config[$configKey] = array_replace_recursive($this->_config[$configKey], $config);
            } else {
                $this->_config[$configKey] = $config;
            }
        } else {
            $this->_config = array_replace_recursive($this->_config, $config);
        }
    }

    /**
     * Get an item from the configuration manager
     *
     * @param string $configKey The key/name of the configuration item.
     *
     * @return mixed The object stored in the config.
     */
    function get($configKey)
    {
        if (isset($this->_config[$configKey])) {
            return $this->_config[$configKey];
        }

        return null;
    }

    public function request($name)
    {
        if ($this->exists($name) !== true) {
            throw new ConfigException(sprintf('No service with the name %s already exists.', $name));
        }

        return $this->_config[$name];
    }

    /**
     * Check whether an item exists in the configuration manager.
     *
     * @param string $configKey The key/name of the configuration item.
     *
     * @return bool Whether an object with the key exists.
     */
    function exists($configKey)
    {
        return isset($this->_config[$configKey]);
    }

    /**
     * Return a sub-item in the configuration array. It will be an instance of the AbstractConfiguration manager.
     *
     * @param string $configKey The key/name of the configuration item.
     *
     * @return AbstractConfigManager The sub-item in configuration.
     */
    function sub($configKey)
    {
        if (array_key_exists($configKey, $this->_config)) {
            $this->_config = $this->_config[$configKey];
        }

        return $this;
    }

    /**
     * Return the current configuration as an array.
     *
     * @return array Return the specified configuration as an array.
     */
    function asArray()
    {
        return $this->_config;
    }
}