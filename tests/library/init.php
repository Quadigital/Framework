<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */
define('TESTING', 'development');

// Changes PHP's current directory to the base
chdir(dirname(dirname(__DIR__)) . '/src');

//
include 'library/constants.php';
//
include 'library/autoload.php';
// Include Test autoloader
include __DIR__ . '/autoload.php';

//
define('TEST_DIR', ROOT_DIR . DS . DIR_UP . 'tests' . DS);

// Include/autoload phpunit librarys.
include TEST_DIR . 'vendor/autoload.php';

//include 'library/Quadigital/Core/bootstrap.php';