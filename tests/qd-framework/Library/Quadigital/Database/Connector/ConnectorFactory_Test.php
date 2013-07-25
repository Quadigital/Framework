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
        'username' => 'root',
        'password' => 'test123',
        'port' => '3306',
        'host' => 'localhost',
        'database' => 'greetgate',
    );

    public function test_invalidRdbms()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00002);

        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory('invalid', $this->_dbOptions);
        $connectorFactory->make();
    }

    public function test_setRdbms()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory('invalid', $this->_dbOptions);

        try {
            $connectorFactory->make();
        } catch (\Quadigital\Database\Exception\DatabaseException $dbException) {
            // Exception should be thrown.
            if ($dbException->getMessage() !== ERROR_E00002) {
                $this->fail('Incorrect database exception thrown.');
            }

            $connectorFactory->setRdbmsType('mysql');
            /** @var \Quadigital\Database\Connector\MySqlConnector $mysqlConnector */
            $mysqlConnector = $connectorFactory->make();

            $this->assertInstanceOf('\PDO', $mysqlConnector,
                'Object returned by connector factory should of been a PDO instance.');

            return; // Return so that fail isn't run when there was an exception and it was caught.
        }

        $this->fail('Database exception should of been thrown.');
    }

    public function test_invalidConnectionOptions()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00004);

        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory('mysql', array());
        $connectorFactory->make();
    }

    public function test_setConnectionOptions()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory('mysql', array());

        try {
            $connectorFactory->make();
        } catch (\Quadigital\Database\Exception\DatabaseException $dbException) {
            // Exception should be thrown.
            if ($dbException->getMessage() !== ERROR_E00004) {
                $this->fail('Incorrect database exception thrown.');
            }

            // Only setting the host and database names, so login credentials are still missing.
            $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00001);

            $connectorFactory->setOptions(array(
                'host' => 'localhost',
                'database' => 'greetgate',
            ));

            $connectorFactory->make();
        }

        $this->fail('Database exception should of been thrown.');
    }

    public function test_addConnectionOption()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory('mysql', array());

        try {
            $connectorFactory->make();
        } catch (\Quadigital\Database\Exception\DatabaseException $dbException) {
            // Exception should be thrown.
            if ($dbException->getMessage() !== ERROR_E00004) {
                $this->fail('Incorrect database exception thrown.');
            }

            // Only adding the host and database names, so login credentials are still missing.
            $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00001);

            $connectorFactory
                ->addOption('host', 'localhost')
                ->addOption('database', 'greetgate');

            $connectorFactory->make();
        }

        $this->fail('Database exception should of been thrown.');
    }

    public function test_mysqlConnector()
    {
        $connectorFactory = new \Quadigital\Database\Connector\ConnectorFactory('mysql', $this->_dbOptions);
        $mysqlConnector = $connectorFactory->make();

        $this->assertInstanceOf('\PDO', $mysqlConnector,
            'Object returned by connector factory should of been a PDO instance.');
    }
}
