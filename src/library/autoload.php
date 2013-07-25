<?php
require getcwd() . '/vendor/autoload.php';
//Twig_Autoloader::register();

/**
 * Class QdAutoload
 */
class Autoload
{

    /**
     * Class-to-file mappings storage
     *
     * @var array
     */
    private static $_class2File = array();

    /**
     * @var array
     */
    private static $_classMap = array();

    /**
     * Function registers classname-to-file mapping to load classes
     *
     * @param string $className
     * @param string $filename
     */
    public static function registerClass($className, $filename) {
        if (!is_readable($filename)) {
            return;
        }

        self::$_class2File[$className] = $filename;
    }

    /**
     * @param $className
     */
    static function autoloadLibrary($className) {
        if (strpos($className, 'Quadigital') !== 0) {
            return;
        }

        if (file_exists(LIBRARY_DIR . $className . '.php')) {
            require LIBRARY_DIR . $className . '.php';
        }
    }

    /**
     * @param $className
     */
    static function autoloadModule($className) {
        // 6 is the length of needle ('Module').
        if (strrpos($className, 'Module') !== strlen($className) - 6 ) {
            return;
        }

        if (file_exists(MODULE_DIR . $className . '.php')) {
            require MODULE_DIR . $className . '.php';
        }
    }
}

// Register autoloaders
spl_autoload_register(array('Autoload', 'autoloadLibrary'));
spl_autoload_register(array('Autoload', 'autoloadModule'));
//spl_autoload_register(array('Autoload', 'autoloadModuleContents'));