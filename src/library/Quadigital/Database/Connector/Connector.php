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

use Quadigital\Database\Exception\DatabaseException;

class Connector {

    /**
     * The default \PDO connection options.
     *
     * @var array
     */
    protected $options = array(
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_ORACLE_NULLS => \PDO::NULL_NATURAL,
        \PDO::ATTR_STRINGIFY_FETCHES => false,
        \PDO::ATTR_EMULATE_PREPARES => false,
    );

    /**
     * Get the PDO options based on the configuration.
     *
     * @param  array  $config
     * @return array
     */
    public function getOptions(array $config)
    {
        $options = isset($config['options']) ? $config['options'] : array();

        return array_diff_key($this->options, $options) + $options;
    }

    /**
     * Create a new \PDO connection.
     *
     * @param  string  $dsn
     * @param  array   $config
     * @param  array   $options
     *
     * @return bool successful
     */
    protected function createConnection($dsn, array $config, array $options)
    {
        if (!isset($config['username'], $config['password'])) {
            throw new DatabaseException(ERROR_E00001);
        }

        return new \PDO($dsn, $config['username'], $config['password'], $options);
    }

    /**
     * Get the default \PDO connection options.
     *
     * @return array
     */
    public function getDefaultOptions()
    {
        return $this->options;
    }

    /**
     * Set the default \PDO connection options.
     *
     * @param  array  $options
     * @return void
     */
    public function setDefaultOptions(array $options)
    {
        $this->options = $options;
    }
}