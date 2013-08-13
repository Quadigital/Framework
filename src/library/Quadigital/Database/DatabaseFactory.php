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
use Quadigital\Factory\LibraryCreator;

class DatabaseFactory extends LibraryCreator {

    private $_dbConfig = null;

    public function __construct(array $dbConfig)
    {
        $this->_dbConfig = $dbConfig;
    }

    protected function factoryMethod()
    {
        $connectorFactory = new ConnectorFactory($this->_dbConfig);
        $connection = $connectorFactory->make();

        $connectionDriverName = $connection->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $connectionInstance = null;

        switch($connectionDriverName) {
            case 'mysql':
                $connectionInstance = new MySqlConnection($connection);
                break;
            default:
                break;
        }

        return $connectionInstance;
    }
}