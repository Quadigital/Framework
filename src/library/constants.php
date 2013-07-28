<?php
/**
 * Created by JetBrains PhpStorm.
 * User: RiversA
 * Date: 13/03/13
 * Time: 15:34
 * To change this template use File | Settings | File Templates.
 */

// Directory constants
define('DS', DIRECTORY_SEPARATOR);
define('DIR_UP', '..' . DS);
define('ROOT_DIR', getcwd());
define('LIBRARY_DIR', ROOT_DIR . DS . 'library' . DS);
define('CACHE_DIR', ROOT_DIR . DS . 'cache' . DS);
define('CONFIG_DIR', ROOT_DIR . DS . 'config' . DS);
define('MODULE_DIR', ROOT_DIR . DS . 'module' . DS);

// Debug constants
define('DEBUG', false);
define('START_TIME', microtime(true));

// Error
define('ERROR_E00001', 'The RDBMS type you specified is not supported.');
define('ERROR_E00002', 'The database connector instance is null.');
define('ERROR_E00003', 'RDBMS is required and must be a string.');
define('ERROR_E00004', 'Database username and password are required and must be strings.');
define('ERROR_E00005', 'Database host and database are required and must be strings.');
define('ERROR_E00006', 'Database port is optional but must be an integer if it is set.');
define('ERROR_E00007', 'Connection options are optional but must be passed as an array if set.');
define('ERROR_E00008', 'Database port must be in the valid port range (0-65535).');