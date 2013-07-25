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

/**
 * File in control of database connection and interactions with the database.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
abstract class AbstractDbModel
{
    protected $databaseColumns = array();

    /**
     * Gets passed data in an array and passes it on to the class variables.
     *
     * @param array $array
     *
     * @return mixed
     */
    abstract function exchangeArray(array $array);

    /**
     * Gets passed data in an array and passes it on to the class variables.
     *
     * @return array
     */
    public function toArray($ignoreNullRows) {
        $result = array();

        foreach($this->databaseColumns as $column) {
            if ($ignoreNullRows !== true || $this->{$column} !== null) {
                $result[$column] = $this->{$column};
            }
        }

        return $result;
    }
}