<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class Host_Test extends PHPUnit_Framework_TestCase
{

    public function test_host()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('host' => 'localhost'));

        $this->assertEquals($dbConfigInst->getHost(), 'localhost');
    }

    public function test_hostTrim()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('host' => '   localhost '));

        $this->assertEquals($dbConfigInst->getHost(), 'localhost');
    }

    public function test_hostWhitespace()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00004);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('host' => '     '));

        $dbConfigInst->getHost();
    }


    public function test_unsetHost()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00004);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig();
        $dbConfigInst->getHost();
    }
}
