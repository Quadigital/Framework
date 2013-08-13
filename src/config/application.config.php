<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

return array(
    'modules' => array(
        'Application',
    ),
    'factories' => array(
//        'DatabaseConfig' => array(
//            'Class' => 'Quadigital\Database\DatabaseSettingsFactory',
//            'Parameters' => array(
//                'DatabaseConfig' => array(
//                    'Storage' => 'Config',
//                    'Name' => 'DatabaseConfig'
//                ),
//            ),
//            'Storage' => 'Config',
//        ),
        'Database' => array(
            'Class' => 'Quadigital\Database\DatabaseFactory',
            'Parameters' => array(
                'DatabaseConfigInstance' => array(
                    'Storage' => 'Config',
                    'Name' => 'DatabaseConfig'
                ),
            ),
            'Storage' => 'Service',
        ),
    ),
);