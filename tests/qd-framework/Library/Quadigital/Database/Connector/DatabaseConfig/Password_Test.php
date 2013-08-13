<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class Password_Test extends PHPUnit_Framework_TestCase
{

    public function test_password()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('password' => 'test123'));

        $this->assertEquals($dbConfigInst->getPassword(), 'test123');
    }

    public function test_passwordTrim()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('password' => '   test123 '));

        $this->assertEquals($dbConfigInst->getPassword(), 'test123');
    }

    public function test_passwordWhitespace()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('password' => '     '));

        $this->assertEquals($dbConfigInst->getPassword(), '');
    }


    public function test_unsetPassword()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig();

        $this->assertEquals($dbConfigInst->getPassword(), '');
    }
}
