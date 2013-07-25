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
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00002);

        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory($this->_dbOptions);
        $connectorFactory->make();
    }

    public function test_invalidRdbms_null()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00005);

        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory($this->_dbOptions);
        $connectorFactory->make();
    }

    public function test_invalidRdbms_incorrectType()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00005);

        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory($this->_dbOptions);
        $connectorFactory->make();
    }

    public function test_correctRdbms()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory($this->_dbOptions);
            /** @var \Quadigital\Database\Connector\MySqlConnector $mysqlConnector */
            $mysqlConnector = $connectorFactory->make();

            $this->assertInstanceOf('\PDO', $mysqlConnector,
                'Object returned by connector factory should of been a PDO instance.');
    }

    public function test_invalidConnectionOptions()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00004);

        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory(array());
        $connectorFactory->make();
    }

    public function test_onlyHostAndDbNameOptions()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory(array(
            'host' => 'localhost',
            'database' => 'greetgate',
        ));

        // Only setting the host and database names, so login credentials are still missing.
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00001);

        $connectorFactory->make();
    }

    public function test_mysqlConnector()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory($this->_dbOptions);
        $mysqlConnector = $connectorFactory->make();

        $this->assertInstanceOf('\PDO', $mysqlConnector,
            'Object returned by connector factory should of been a PDO instance.');
    }
}
