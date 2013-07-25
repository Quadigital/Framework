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

class DatabaseConfig {

    private $_rdbms;
    private $_username;
    private $_password;
    private $_host;
    private $_database;
    private $_port;
    private $_options;

    public function __construct(array $dbConfig) {
        if (!isset($dbConfig['rdbms']) || !ctype_alpha($dbConfig['rdbms'])) {
            throw new DatabaseException('RDBMS is required and must be a string.');
        }
        if (!isset($dbConfig['username']) || !is_string($dbConfig['username']) ||
            !isset($dbConfig['password']) || !is_string($dbConfig['password'])) {
            throw new DatabaseException('Database username and password are required and must be strings.');
        }
        if (!isset($dbConfig['host']) || !is_string($dbConfig['host']) ||
            !isset($dbConfig['database']) || !is_string($dbConfig['database'])) {
            throw new DatabaseException('Database host and database are required and must be strings.');
        }
        if (isset($dbConfig['port']) && !is_numeric($dbConfig['port'])) {
            throw new DatabaseException('Database port is optional but must be numeric if it is set.');
        }
        if (isset($dbConfig['options']) && !is_array($dbConfig['options'])) {
            throw new DatabaseException('Connection options are optional but must be passed as an array if set.');
        }

        $this->_rdbms = $dbConfig['rdbms'];
        $this->_username = $dbConfig['username'];
        $this->_password = $dbConfig['password'];
        $this->_host = $dbConfig['host'];
        $this->_database = $dbConfig['database'];
        $this->_port = isset($dbConfig['port']) ? $dbConfig['port'] : null;
        $this->_options = isset($dbConfig['options']) ? $dbConfig['options'] : array();
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->_database;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @return null
     */
    public function getPort()
    {
        return $this->_port;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @return mixed
     */
    public function getRdbms()
    {
        return $this->_rdbms;
    }



} 