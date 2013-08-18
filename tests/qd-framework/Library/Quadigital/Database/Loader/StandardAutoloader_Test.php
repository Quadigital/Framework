<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

include 'library/Quadigital/Loader/StandardAutoloader.php';

class StandardAutoloader_Test extends PHPUnit_Framework_TestCase
{
    public function test_autoloadRegister()
    {
        $autoloader = new \Quadigital\Loader\StandardAutoloader;
        $autoloader->register();

        $autoloaderFunctions = spl_autoload_functions();

        $result = array_filter($autoloaderFunctions, function($autoloadFunction) {
            return isset($autoloadFunction[0]) && isset($autoloadFunction[1]) &&
            $autoloadFunction[0] instanceof \Quadigital\Loader\StandardAutoloader &&
            $autoloadFunction[1] == 'autoload';
        });

        $this->assertEquals(1, count($result));
    }

    public function test_autoload()
    {
        new \Quadigital\Core\Application();
    }

}
