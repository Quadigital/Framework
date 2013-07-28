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
        $configKeys = array('database', 'host', 'options', 'password', 'port', 'rdbms', 'username');

        foreach ($configKeys as $key) {
            if (isset($config[$key])) {
                switch ($key) {
                    case 'database':
                        $this->setDatabase($config[$key]);
                        break;

                    case 'host':
                        $this->setHost($config[$key]);
                        break;

                    case 'options':
                        $this->setOptions($config[$key]);

                        break;
                    case 'password':
                        $this->setPassword($config[$key]);

                        break;
                    case 'port':
                        $this->setPort($config[$key]);

                        break;
                    case 'rdbms':
                        $this->setRdbms($config[$key]);

                        break;
                    case 'username':
                        $this->setUsername($config[$key]);
                        break;
                }
            }
        }

    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        if (!isset($this->_config['database'])) {
            throw new DatabaseException(ERROR_E00005);
        }

        return $this->_config['database'];
    }

    /**
     * @return string
     */
    public function getHost()
    {
        if (!isset($this->_config['host'])) {
            throw new DatabaseException(ERROR_E00005);
        }

        return $this->_config['host'];
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return isset($this->_config['options']) ? $this->_config['options'] : array();
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        if (!isset($this->_config['password'])) {
            throw new DatabaseException(ERROR_E00004);
        }

        return $this->_config['password'];
    }

    /**
     * @return null
     */
    public function getPort()
    {
        return isset($this->_config['options']) ? $this->_config['options'] : null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        if (!isset($this->_config['username'])) {
            throw new DatabaseException(ERROR_E00004);
        }

        return $this->_config['username'];
    }

    /**
     * @return mixed
     */
    public function getRdbms()
    {
        if (!isset($this->_config['rdbms'])) {
            throw new DatabaseException(ERROR_E00003);
        }

        return $this->_config['rdbms'];
    }

    /**
     * @param string $database
     */
    public function setDatabase($database)
    {
        if (is_string($database)) {
            $database = trim($database);

            if (!empty($database)) {
                $this->_config['database'] = $database;
                return;
            }
        }

        throw new DatabaseException(ERROR_E00005);
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        if (is_string($host)) {
            $host = trim($host);

            if (!empty($host)) {
                $this->_config['host'] = $host;
                return;
            }
        }

        throw new DatabaseException(ERROR_E00005);
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        if ($options === null) {
            $this->_config['options'] = array();
            return;
        } elseif (is_array($options)) {
            $this->_config['options'] = $options;
            return;
        }

        throw new DatabaseException(ERROR_E00007);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        if (is_string($password)) {
            $password = trim($password);

            if (!empty($password)) {
                $this->_config['password'] = $password;
                return;
            }
        }

        throw new DatabaseException(ERROR_E00004);
    }

    /**
     * @param null|int $port
     */
    public function setPort($port)
    {
        if ($port === null) {
            $this->_config['port'] = null;
            return;
        } elseif (is_numeric($port)) {
            $port = intval($port);

            if (is_int($port)) {
                if ($port > 0 && $port < 65535) {
                    $this->_config['port'] = $port;
                    return;
                }

                throw new DatabaseException(ERROR_E00008);
            }
        }

        throw new DatabaseException(ERROR_E00006);
    }

    /**
     * @param mixed $rdbms
     */
    public function setRdbms($rdbms)
    {
        if (is_string($rdbms)) {
            $rdbms = trim($rdbms);

            if (ctype_alpha($rdbms) && !empty($rdbms)) {
                $this->_config['rdbms'] = $rdbms;
                return;
            }
        }

        throw new DatabaseException(ERROR_E00003);
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        if (is_string($username)) {
            $username = trim($username);

            if (!empty($username)) {
                $this->_config['username'] = $username;
                return;
            }
        }

        throw new DatabaseException(ERROR_E00004);
    }
}