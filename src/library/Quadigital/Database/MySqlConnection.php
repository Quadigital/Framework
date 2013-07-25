<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Database;


class MySqlConnection extends Connection {

    /**
     * Run a query and if a value array is specified then the values will be prepared/escaped first.
     *
     * @param string $query_string Query string to execute.
     * @param null|array $value_array  Value array to execute (and escape).
     *
     * @return null|\PDOStatement
     */
    public function query($query_string, $value_array = null)
    {
        if ($value_array !== null) {
            $result = $this->connection->prepare($query_string);
            $result->execute($value_array);
        } else {
            $result = $this->connection->query($query_string);
        }
        return (is_bool($result) === true) ? null : $result;
    }

}