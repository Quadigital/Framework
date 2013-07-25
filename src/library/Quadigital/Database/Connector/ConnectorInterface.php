<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Database\Connector;


/**
 * Class ConnectorInterface
 * @package Quadigital\Database\Connector
 */
interface ConnectorInterface {

    /**
     * Establish a database connection.
     *
     * @param  array  $options
     *
     * @return \PDO
     */
    public function connect(DatabaseConfig $config);

}