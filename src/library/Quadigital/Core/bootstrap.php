<?php
/**
 * System Initialization File
 *
 * Loads the base classes and executes the request.
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

/**
 * ---------------------------------------------------------------
 *   Quadigital framework version
 * ---------------------------------------------------------------
 */
define('QDF_VERSION', '1.000 Development. BUILD 1');

/*
 * ---------------------------------------------------------------
 *   Error reporting
 * ---------------------------------------------------------------
 */

if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
            break;

        case 'testing':
        case 'production':
            error_reporting(0);
            break;

        default:
            exit('The application environment is not set correctly. E000001');
    }
} else {
    exit('The application environment is not set correctly. E000001');
}

/*
 * ------------------------------------------------------
 *   Load the framework constants
 * ------------------------------------------------------
 */
if (defined('ENVIRONMENT') && file_exists('library/'.ENVIRONMENT.'-constants.php')) {
    require 'library/' . ENVIRONMENT . '-constants.php';
} elseif (file_exists('library/constants.php')) {
    require 'library/constants.php';
} else {
    exit('The application constants could not be found. E000002');
}

/*
 * ------------------------------------------------------
 *   Load application autoloader
 * ------------------------------------------------------
 */
if (file_exists(LIBRARY_DIR . 'autoload.php')) {
    require LIBRARY_DIR . 'autoload.php';
} else {
    exit('The application constants could not be found. E000003');
}

/*
 * ------------------------------------------------------
 *   Load composer autoloader
 * ------------------------------------------------------
 */
if (file_exists(ROOT_DIR . '/vendor/autoload.php')) {
    require ROOT_DIR . '/vendor/autoload.php';
} else {
    exit('The vendor autoloader couldn\'t be found. E000003');
}

/*
 * ------------------------------------------------------
 *   Save the application config to a variable
 * ------------------------------------------------------
 */
$appConfig = null;

if (defined('ENVIRONMENT') && file_exists(CONFIG_DIR . ENVIRONMENT . DS . 'application.config.php')) {
    $appConfig = require CONFIG_DIR . ENVIRONMENT . DS . 'application.config.php';
} elseif (file_exists(CONFIG_DIR . 'application.config.php')) {
    $appConfig = require CONFIG_DIR . 'application.config.php';
} else {
    exit('The application config could not be found. E000004');
}

if (!is_array($appConfig)) {
    exit('The application config could not be loaded. E000005');
}

/*
 * ------------------------------------------------------
 *   Initialise config and service managers
 * ------------------------------------------------------
 */
$configManagerFactory = new \Quadigital\Config\ConfigManagerFactory($appConfig);
$configManager = $configManagerFactory->make();

$serviceManager = \Quadigital\Service\ServiceManager::getServiceMananger();

$serviceManagerType = $configManager->get('ServiceManager');
if (isset($serviceManagerType)) {
    \Quadigital\Service\ServiceManager::setType($serviceManagerType);
} else {
    exit('Invalid service manager type. E000006');
}

$serviceManager->register('Config', $configManager);

/*
 * ------------------------------------------------------
 *   Add database config to config manager if it is found
 * ------------------------------------------------------
 */
if (defined('ENVIRONMENT') && file_exists(CONFIG_DIR . ENVIRONMENT . DS . 'database.config.php')) {
    $dbConfig = require CONFIG_DIR . ENVIRONMENT . DS . 'database.config.php';
    $configManager->add($dbConfig, 'DatabaseConfig');
} elseif (file_exists(CONFIG_DIR . 'database.config.php')) {
    $dbConfig = require CONFIG_DIR . 'database.config.php';
    $configManager->add($dbConfig, 'DatabaseConfig');
}

/*
 * ------------------------------------------------------
 *   Load all factories
 * ------------------------------------------------------
 */
if ($configManager->exists('factories')) {
    $factoryLoader = new \Quadigital\Factory\LoadFactories($configManager->get('factories'));
    $factoryLoader->make();
}

/*
 * ------------------------------------------------------
 *   Launch the application
 * ------------------------------------------------------
 */
$app = new \Quadigital\Core\Application();
$app->run();