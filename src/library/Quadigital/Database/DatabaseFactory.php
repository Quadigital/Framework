<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Database;

use Quadigital\Database\Connector\ConnectorFactory;
use Quadigital\Database\Exception\DatabaseException;
use Quadigital\Factory\LibraryCreator;

class DatabaseFactory extends LibraryCreator {

    private $_dbConfig = null;

    public function __construct(array $dbConfig)
    {
        $this->_dbConfig = $dbConfig;
    }

    private $_dbAdapters = array(
        'pdo_mysql' => array(
            'rdbmsType' => 'mysql',
            'connection' => 'MySqlConnection',
        ),
    );

    protected function factoryMethod()
    {
        if (isset($this->_dbConfig['adapter'])) {
            $adapter = $this->_dbConfig['adapter'];

            if (!isset($this->_dbAdapters[strtolower($adapter)])) {
                    throw new DatabaseException('An invalid/unsupported database adapter was set.');
            }

            $dbAdapterSettings = $this->_dbAdapters[$adapter];
            $connectorFactory = new ConnectorFactory($dbAdapterSettings['rdbmsType'], $this->_dbConfig);
            $dbConnection = $connectorFactory->make();

            return $dbConnection;
        }

        // No adapter set
        throw new DatabaseException('No database adapter was set.');
    }
}