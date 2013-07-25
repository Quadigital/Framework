<?php
/**
 * The main index file which takes all requests and passes them to the MVC
 * application to handle.
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

/*
 * ---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 * ---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
define('ENVIRONMENT', 'development');

ob_start();

// Changes PHP's current directory to the base
chdir(dirname(__DIR__));

include 'library/Quadigital/Core/bootstrap.php';

//Quadigital\MVC\Application::init(require CONFIG . 'application.config.php')->run();

ob_flush();