9<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class Options_Test extends PHPUnit_Framework_TestCase
{

    public function test_options()
    {
        $options = array('key' => 'value');

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('options' => $options));

        $this->assertEquals($dbConfigInst->getOptions(), $options);
    }

    public function test_optionsNonArray()
    {
        $options = '';

        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig(array('options' => $options));

        $this->assertEquals($dbConfigInst->getOptions(), array());
    }

    public function test_unsetRdbms()
    {
        $dbConfigInst = new \Quadigital\Database\Connector\DatabaseConfig();

        $this->assertEquals($dbConfigInst->getOptions(), array());
    }
}
