<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Config;

use Quadigital\Factory\Creator;
use Quadigital\Module\AbstractModule;
use Quadigital\Config\Exception\ConfigException;

class ConfigManagerFactory extends Creator {

    private $_appConfig = null;

    public function __construct(array $appConfig) {
        $this->_appConfig = $appConfig;
    }

    protected function factoryMethod()
    {
        $configManager = new ConfigManager($this->_appConfig);

        if (!$configManager->exists('modules')) {
            throw new ConfigException('No modules could be found in the config manager.');
        }

        /** @var ConfigManager $modules */
        $modules = $configManager->get('modules');

        foreach ($modules as $module) {
            $moduleClassName = sprintf('%s\Module', $module);

            $moduleClass = new $moduleClassName();

            if ($moduleClass instanceof AbstractModule) {
                $moduleConfig = $moduleClass->getConfigArray();

                if (is_array($moduleConfig) && count($moduleConfig) !== 0) {
                    $configManager->add($moduleConfig);
                }
            }
        }

        return $configManager;
    }
}