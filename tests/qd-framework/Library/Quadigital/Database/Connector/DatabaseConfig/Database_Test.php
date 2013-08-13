<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class Database_Test extends PHPUnit_Framework_TestCase
{

    public function test_rdbms()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('database' => 'dbname'));

        $this->assertEquals($dbConfigInst->getDatabase(), 'dbname');
    }

    public function test_databaseTrim()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('database' => '   dbname '));

        $this->assertEquals($dbConfigInst->getDatabase(), 'dbname');
    }

    public function test_databaseWhitespace()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00004);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('database' => '     '));

        $dbConfigInst->getDatabase();
    }


    public function test_unsetDatabase()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00004);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig();
        $dbConfigInst->getDatabase();
    }
}
