<?php

/**
 * File in control of database connection and interactions with the database.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
namespace Quadigital\Database;

use Quadigital\Database\DbAdapter\AbstractAdapter;
use Quadigital\Database\Query\Query;

/**
 * File in control of database connection and interactions with the database.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class AbstractTableGateway
{
    private $_connection = null;
    private $_tableName = null;

    /**
     * Create a new instance of the Table gateway.
     *
     * @param AbstractAdapter $connection
     * @param string          $tableName
     */
    public function __construct(AbstractAdapter $connection, $tableName)
    {
        $this->_connection = $connection;
        $this->_tableName = $tableName;
    }

    /**
     * Return a query object for the current table gateway.
     *
     * @param AbstractDbModel $dbModel
     * @param null|string     $queryString
     *
     * @return null|Query
     */
    public function query(AbstractDbModel $dbModel = null, $queryString = null)
    {
        $queryInstance = new Query($this->_connection, $this->_tableName, $dbModel);

        if ($queryString !== null) {
            return null;
        }

        return $queryInstance;
    }
}