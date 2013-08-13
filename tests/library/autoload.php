<?php
/**
 * Class QdAutoload
 */
class TestFrameworkAutoload
{
    /**
     * @param $className
     */
    static function autoloadTestLibrary($className) {
        if (strpos($className, 'Quadigital') !== 0) {
            return;
        }

        if (file_exists(__DIR__ . DS . $className . '.php')) {
            require __DIR__ . DS . $className . '.php';
        }
    }
}

// Register autoloaders
spl_autoload_register(array('TestFrameworkAutoload', 'autoloadTestLibrary'));