<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

use Quadigital\Test\Reflection\Reflection as QdReflection;



class Connector_Test extends PHPUnit_Framework_TestCase
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
        new \Quadigital\Database\Connector\Connector();
    }

    public function test_disableDefaultOptions()
    {
        $connector = new \Quadigital\Database\Connector\Connector();
        $connector->disableDefaultOptions();

        $this->assertEquals($connector->getOptions(), array());
    }

    public function test_optionsMerge()
    {
        $connector = new \Quadigital\Database\Connector\Connector();
        $defaultOptions = QdReflection::getProperty($connector, '_options');

        $this->assertEquals($connector->getOptions(), $defaultOptions);
    }
}
