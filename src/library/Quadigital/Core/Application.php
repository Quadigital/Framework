<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Core;


use Quadigital\Database\ConnectionInterface;
use Quadigital\Database\DatabaseFactory;
use Quadigital\Service\ServiceManager;

class Application {

    public function run() {
        $dbFactory = new DatabaseFactory(include 'config/database.config.php');
        /** @var ConnectionInterface $connector */
        $db = $dbFactory->make();

        /** @var \PDOStatement $result */
        $result = $db->query('select * from user');

        var_dump($result->fetch());

        $twig = new \Twig_Environment();

        echo 1;
    }
}