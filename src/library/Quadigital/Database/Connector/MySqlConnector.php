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

class MySqlConnector extends Connector implements ConnectorInterface {

    /**
     * Establish a database connection.
     *
     * @param  array  $options
     * @return PDO
     */
    public function connect(array $config = array())
    {
        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);

        $connection = $this->createConnection($dsn, $config, $options);

        return $connection;
    }

    /**
     * Create a DSN string from a configuration.
     *
     * @param  array   $config
     * @return string
     */
    protected function getDsn(array $config)
    {
        if (!isset($config['host'], $config['database'])) {
            throw new DatabaseException(ERROR_E00004);
        }

        $host = $config['host'];
        $database = $config['database'];

        $dsn = "mysql:host={$host};dbname={$database}";

        if (isset($config['port']))
        {
            $dsn .= ";port={$config['port']}";
        }

        return $dsn;
    }

}