<?php
/**
 * File description.
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Database\Connector;


use Quadigital\Database\Exception\DatabaseException;

class DatabaseConfig
{

    private $_config = array();

    public function __construct(array $config = array())
    {
        $this->setFromArray($config);
    }

    public function setFromArray(array $config)
    {
        $validKeys = array('database', 'host', 'options', 'password', 'port', 'rdbms', 'username');

        foreach($validKeys as $key) {
            if ($this->_exists($key, $config)) {
                $this->_config[$key] = $config[$key];
            }
        }
    }

    private function _exists($key, $config = null) {
        if ($config === null) {
            return isset($this->_config[$key]);
        }

        return isset($config[$key]);
    }

    private function _isString($key, $trim = true) {
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

    private function _isAlpha($key, $trim = true) {
        $isAlpha = false;
        $value = &$this->_config[$key];

        if ($this->_isString($key, $trim) && ctype_alpha($value)) {
            if ($trim) {
                $value = trim($value);
            }

            $isAlpha = true;
        }

        return $isAlpha;
    }

    private function _isNumeric($key, $intVal = true) {
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
     * @return string
     */
    public function getDatabase()
    {
        if ($this->_isString('database') && !empty($this->_config['database'])) {
            return $this->_config['database'];
        }

        throw new DatabaseException(ERROR_E00004);
    }

    /**
     * @return string
     */
    public function getHost()
    {
        if ($this->_isString('host') && !empty($this->_config['host'])) {
            return $this->_config['host'];
        }

        throw new DatabaseException(ERROR_E00004);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if ($this->_exists('options') && is_array($this->_config['options'])) {
             return $this->_config['options'];
        }

        return array();
    }

    /**
     * @return string
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
     * @return string
     */
    public function getUsername()
    {
        if ($this->_isString('username')) {
            return $this->_config['username'];
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getRdbms()
    {
        if ($this->_isAlpha('rdbms') && !empty($this->_config['rdbms'])) {
            return $this->_config['rdbms'];
        }

        throw new DatabaseException(ERROR_E00003);
    }
}