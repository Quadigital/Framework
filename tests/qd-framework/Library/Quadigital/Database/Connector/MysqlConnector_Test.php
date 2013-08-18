<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class MysqlConnector_Test extends PHPUnit_Framework_TestCase
{

    private $_dbOptions = array(
        'rdbms' => 'mysql',
        'username' => 'root',
        'password' => 'test123',
        'port' => '3306',
        'host' => 'localhost',
        'database' => 'greetgate',
    );

    public function test_connector()
    {
        new \Quadigital\Database\Connector\MySqlConnector();
    }

}
