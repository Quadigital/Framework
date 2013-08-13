<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */
namespace Quadigital\Database\Connector;

/**
 * Class Connector
 *
 * @package Quadigital\Database\Connector
 */
class Connector {

    /**
     * @var array The default \PDO connection options.
     */
    private $_options = array(
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_ORACLE_NULLS => \PDO::NULL_NATURAL,
        \PDO::ATTR_STRINGIFY_FETCHES => false,
        \PDO::ATTR_EMULATE_PREPARES => false,
    );

    /**
     * Get an array of options for the connection by merging the default options
     * and the custom options passed as a parameter.
     *
     * @param array $config An array containing the custom connection options.
     *
     * @return array
     */
    public function getOptions(array $config = array())
    {
        if (count($config) === 0) {
            return $this->_options;
        }

        return array_diff_key($this->_options, $config) + $config;
    }

    /**
     * Create a new \PDO connection.
     *
     * @param string         $dsn
     * @param DatabaseConfig $config
     * @param array          $options
     *
     * @return bool successful
     */
    protected function createConnection($dsn, DatabaseConfig $config, array $options = array())
    {
        return new \PDO($dsn, $config->getUsername(), $config->getPassword(), $options);
    }

    /**
     * Set the default \PDO connection options.
     *
     * @return void
     */
    public function disableDefaultOptions()
    {
        $this->_options = array();
    }
}