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
if (file_exists(LIBRARY_DIR . '/Loader/StandardAutoloader.php')) {
    require LIBRARY_DIR . '/Loader/StandardAutoloader.php';

    (new Quadigital\Loader\StandardAutoloader())->register();
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
 *   Load Hook Functions
 * ------------------------------------------------------
 */
if (file_exists(LIBRARY_DIR . '/Quadigital/Hooks/Hooks.php')) {
    require LIBRARY_DIR . '/Quadigital/Hooks/Hooks.php';
}
if (file_exists(LIBRARY_DIR . '/Quadigital/Hooks/Filters.php')) {
    require LIBRARY_DIR . '/Quadigital/Hooks/Filters.php';
}

register_filter('render_element_title', '');

function isValid(\Quadigital\View\Element $element) {
    return $this->isValid_length($element) && $this->isValid_format($element);
}

function isValid_length(\Quadigital\View\Element $element) {
    return count($this->title) < self::SEO_FRIENDLY_TITLE_LENGTH;
}

function isValid_format(\Quadigital\View\Element $element) {
    // Primary Keyword - Secondary Keyword | Brand Name
    $format1 = '/^.*?' . // Primary Keyword
        '(\\s+)(-)(\\s+)' . // ' - '
        '.*?' . // Secondary Keyword
        '(\\s+)(\\|)(\\s+)' . // ' | '
        '.*?/'; // Brand Name

    // Brand Name | Primary Keyword and Secondary Keyword
    $format2 = '/^.*?' . // Primary Keyword
        '(\\s+)(\\|)(\\s+)' . // ' | '
        '.*?/'; // Brand Name

    return preg_match($format2, $element->title) === 1 ||
    preg_match($format1, $this->title) === 1;
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

function footerHookTest() {
    return 'footerHookTest(); Completed.';
}

register_hook('render_view_footer', 'footerHookTest');

// Call bootstrap hook before app is run.
call_hook('bootstrap');

$app = new \Quadigital\Core\Application();
$app->run();

// Call shutdown hook because app has finished running.
call_hook('shutdown');