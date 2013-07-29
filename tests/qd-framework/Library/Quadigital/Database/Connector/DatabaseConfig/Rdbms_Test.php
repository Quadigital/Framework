9<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class Rdbms_Test extends PHPUnit_Framework_TestCase
{

    public function test_rdbms()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('rdbms' => 'mysql'));

        $this->assertEquals($dbConfigInst->getRdbms(), 'mysql');
    }

    public function test_rdbmsNonAlpha()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00003);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('rdbms' => 'mysql1'));

        $dbConfigInst->getRdbms();
    }

    public function test_rdbmsNonAlpha2()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00003);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('rdbms' => 'mysql/'));

        $dbConfigInst->getRdbms();
    }

    public function test_setRdbmsTrim()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('rdbms' => '   mysql '));

        $this->assertEquals($dbConfigInst->getRdbms(), 'mysql');
    }

    public function test_setRdbmsWhitespace()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00003);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('rdbms' => '     '));

        $dbConfigInst->getRdbms();
    }


    public function test_unsetRdbms()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', ERROR_E00003);

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig();
        $dbConfigInst->getRdbms();
    }
}
