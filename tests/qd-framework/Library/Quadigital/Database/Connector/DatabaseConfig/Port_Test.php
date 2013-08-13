<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class Port_Test extends PHPUnit_Framework_TestCase
{

    public function test_port()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('port' => 3306));

        $this->assertEquals($dbConfigInst->getPort(), 3306);
    }

    public function test_portString()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('port' => '3306'));

        $this->assertEquals($dbConfigInst->getPort(), 3306);
    }

    public function test_portNonNumeric()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('port' => '3306/'));

        $this->assertEquals($dbConfigInst->getPort(), null);
    }

    public function test_portNonNumeric2()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('port' => '3306a'));

        $this->assertEquals($dbConfigInst->getPort(), null);
    }

    public function test_unsetPort()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig();

        $this->assertEquals($dbConfigInst->getPort(), null);
    }
}
