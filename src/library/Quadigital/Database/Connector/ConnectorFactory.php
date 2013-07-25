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
use Quadigital\Factory\Creator;

/**
 * Class ConnectorFactory
 * @package Quadigital\Database\Connector
 */
class ConnectorFactory extends Creator
{
    /**
     * @var DatabaseConfig
     */
    private $_options;

    /**
     * @param $rdbmsType
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->_options = new DatabaseConfig($options);
    }

    /**
     * @return \PDO
     * @throws \Quadigital\Database\Exception\DatabaseException
     */
    protected function factoryMethod()
    {
        /** @var ConnectorInterface $connector */
        $connector = null;

        switch($this->_options->getRdbms()) {
            case 'mysql':
                $connector = new MySqlConnector();
                break;
            default:
                // Unrecognised rdbmsType
                throw new DatabaseException(ERROR_E00002);
                break;
        }

        if (!$connector instanceof Connector) {
            // Fail-safe in case connector wasn't set properly.
            throw new DatabaseException(ERROR_E00003);
        }

        return $connector->connect($this->_options);
    }
}