<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class ConnectorFactory_Test extends PHPUnit_Framework_TestCase
{

    private $_dbOptions = array(
        'rdbms' => 'mysql',
        'username' => 'root',
        'password' => 'test123',
        'port' => '3306',
        'host' => 'localhost',
        'database' => 'greetgate',
    );

    public function test_invalidRdbms()
    {
        $dboptions = $this->_dbOptions;
        $dboptions['rdbms'] = 'invalid';

        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00001);

        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory($dboptions);
        $connectorFactory->make();
    }

    public function test_mysqlRdbmsConnector()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory($this->_dbOptions);
        $mysqlConnector = $connectorFactory->make();

        $this->assertInstanceOf('\PDO', $mysqlConnector,
            'Object returned by connector factory should of been a PDO instance.');
    }
}
