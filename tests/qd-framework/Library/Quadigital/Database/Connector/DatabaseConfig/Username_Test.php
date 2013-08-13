<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class Username_Test extends PHPUnit_Framework_TestCase
{

    public function test_username()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('username' => 'root'));

        $this->assertEquals($dbConfigInst->getUsername(), 'root');
    }

    public function test_usernameTrim()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('username' => '   root '));

        $this->assertEquals($dbConfigInst->getUsername(), 'root');
    }

    public function test_usernameWhitespace()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('username' => '     '));

        $this->assertEquals($dbConfigInst->getUsername(), '');
    }


    public function test_unsetPassword()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig();

        $this->assertEquals($dbConfigInst->getUsername(), '');
    }
}
