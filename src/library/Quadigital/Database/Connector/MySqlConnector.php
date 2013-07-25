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

/**
 * Class MySqlConnector
 * @package Quadigital\Database\Connector
 */
class MySqlConnector extends Connector implements ConnectorInterface {

    /**
     * Establish a database connection.
     *
     * @param  array  $options
     * @return PDO
     */
    public function connect(DatabaseConfig $config)
    {
        $dsn = $this->getDsn($config);
        $options = $this->getOptions($config->getOptions());

        return $this->createConnection($dsn, $config, $options);
    }

    /**
     * Create a DSN string from a configuration.
     *
     * @param  array   $config
     * @return string
     */
    protected function getDsn(DatabaseConfig $config)
    {
        $dsn = "mysql:host={$config->getHost()};dbname={$config->getDatabase()}";

        if ($config->getPort() !== null)
        {
            $dsn .= ";port={$config->getPort()}";
        }

        return $dsn;
    }

}