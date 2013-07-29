<?php
/**
 * This file contains the database configuration class that simply holds and
 * validates the database configuration options.
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */
namespace Quadigital\Database\Connector;

use Quadigital\Database\Exception\DatabaseException;

/**
 * Class DatabaseConfig
 *
 * @package Quadigital\Database\Connector
 */
class DatabaseConfig
{

    /**
     * @var array Array containing the database configuration.
     */
    private $_config = array();

    /**
     * Database configuration constructor. Sets the database configuration using the elements in the array.
     * Valid keys: 'database', 'host', 'options', 'password', 'port', 'rdbms', 'username'.
     *
     * @param array $config Array containing the database configuration.
     */
    public function __construct(array $config = array())
    {
        $this->setFromArray($config);
    }

    /**
     * Set database configuration using elements in the array.
     * Valid keys: 'database', 'host', 'options', 'password', 'port', 'rdbms', 'username'.
     *
     * @param array $config Array containing the database configuration.
     */
    public function setFromArray(array $config)
    {
        $validKeys = array('database', 'host', 'options', 'password', 'port', 'rdbms', 'username');

        foreach($validKeys as $key) {
            if ($this->_exists($key, $config)) {
                $this->_config[$key] = $config[$key];
            }
        }
    }

    /**
     * Checks to see if an element is present in an array.
     *
     * @param string     $key    The key of the element to check array for.
     * @param null|array $config The array to search. If null then it will check the config
     *                           property. By default this is null.
     *
     * @return bool True if the key exists in the array.
     */
    private function _exists($key, $config = null)
    {
        if ($config === null) {
            return isset($this->_config[$key]);
        }

        return isset($config[$key]);
    }

    /**
     * Check if an element in an array is a string. Also allows the option to trim the string.
     *
     * @param string $key  The key of the element to check value for.
     * @param bool   $trim Trim the value if it is a string? By default this is true.
     *
     * @return bool True if the value for the specified specified element is a string.
     */
    private function _isString($key, $trim = true)
    {
        $isString = false;
        $value = &$this->_config[$key];

        if (is_string($value)) {
            if ($trim) {
                $value = trim($value);
            }

            $isString = true;
        }

        return $isString;
    }

    /**
     * Check if an element in an array contains only alphabetical characters. Also allows the option to trim the string.
     *
     * @param string $key  The key of the element to check value for.
     * @param bool   $trim Trim the value if it is alphabetic? By default this is true.
     *
     * @return bool True if the value of the specified element contains only alphabetical characters.
     */
    private function _isAlpha($key, $trim = true)
    {
        $isAlpha = false;
        $value = &$this->_config[$key];

        // If trim is enabled then execute '_isString()' first so any whitespace can be trimmed.
        if ((!$trim || $this->_isString($key, $trim)) && ctype_alpha($value)) {
            if ($trim) {
                $value = trim($value);
            }

            $isAlpha = true;
        }

        return $isAlpha;
    }

    /**
     * Check if an element in an array is in a numeric format. Also allows the option to get the integer value of
     * element.
     *
     * @param string $key  The key of the element to check value for.
     * @param bool $intVal Get the integer value of the element if it is numeric? By default this is true.
     *
     * @return bool True if the value of the specified element is in a numeric format (numbers in string or integer).
     */
    private function _isNumeric($key, $intVal = true)
    {
        $isNumeric = false;
        $value = &$this->_config[$key];

        if (is_numeric($value)) {
            if ($intVal) {
                $value = intval($value);
            }

            $isNumeric = true;
        }

        return $isNumeric;
    }

    /**
     * Validate that the database name is set and is a string; then return it.
     *
     * @return string Database name.
     *
     * @throws \Quadigital\Database\Exception\DatabaseException Thrown if database name isn't set or isn't a string.
     */
    public function getDatabase()
    {
        if ($this->_isString('database') && !empty($this->_config['database'])) {
            return $this->_config['database'];
        }

        // Something is wrong; database name isn't set or isn't a string. Throw Database Exception.
        throw new DatabaseException(ERROR_E00004);
    }

    /**
     * Validate that the database host is set and is a string; then return it.
     *
     * @return string Database host.
     *
     * @throws \Quadigital\Database\Exception\DatabaseException Thrown if host isn't set or isn't a string.
     */
    public function getHost()
    {
        if ($this->_isString('host') && !empty($this->_config['host'])) {
            return $this->_config['host'];
        }

        // Something is wrong; database host isn't set or isn't a string. Throw Database Exception.
        throw new DatabaseException(ERROR_E00004);
    }

    /**
     * Get the array of PDO driver options. If the array of options set isn't an array then an empty array is returned.
     *
     * @return array Array of PDO driver options.
     */
    public function getOptions()
    {
        if ($this->_exists('options') && is_array($this->_config['options'])) {
             return $this->_config['options'];
        }

        return array();
    }

    /**
     * Validate that the database password is set and is a string; then return it. If it's not set or isn't a valid
     * string then an empty string is returned.
     *
     * @return string Database password.
     */
    public function getPassword()
    {
        if ($this->_isString('password')) {
            return $this->_config['password'];
        }

        return '';
    }

    /**
     * @return null
     */
    public function getPort()
    {
        if ($this->_isNumeric('port')) {
            return $this->_config['port'];
        }

        return null;
    }

    /**
     * Validate that the database username is set and is a string; then return it. If it's not set or isn't a valid
     * string then an empty string is returned.
     *
     * @return string Database username.
     */
    public function getUsername()
    {
        if ($this->_isString('username')) {
            return $this->_config['username'];
        }

        return '';
    }

    /**
     * Validate that the RDBMS (Relational database management system) is set and is a string; then return it.
     *
     * @return string The RDBMS.
     *
     * @throws \Quadigital\Database\Exception\DatabaseException Thrown if RDBMS isn't set or isn't an alphabetical
     * string.
     */
    public function getRdbms()
    {
        if ($this->_isAlpha('rdbms') && !empty($this->_config['rdbms'])) {
            return $this->_config['rdbms'];
        }

        // Something is wrong; RDBMS isn't set or isn't an alphabetical string. Throw Database Exception.
        throw new DatabaseException(ERROR_E00003);
    }
}