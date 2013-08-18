<?php

namespace Quadigital\Loader;

if (interface_exists('Zend\Loader\SplAutoloader')) return;

/**
 * Defines an interface for classes that may register with the spl_autoload
 * registry
 */
interface SplAutoloader
{
    /**
     * Autoload a class
     *
     * @param   $class
     * @return  mixed
     *          False [if unable to load $class]
     *          get_class($class) [if $class is successfully loaded]
     */
    public function autoload($class);

    /**
     * Register the autoloader with spl_autoload registry
     *
     * Typically, the body of this will simply be:
     * <code>
     * spl_autoload_register(array($this, 'autoload'));
     * </code>
     *
     * @return void
     */
    public function register();
}
