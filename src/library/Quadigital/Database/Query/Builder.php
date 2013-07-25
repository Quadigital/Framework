<?php
/**
 * This file contains a simple abstract controller class. This will be used by all of the modules that are used in the
 * application. The controller is the decision maker and the glue between the model and view. The controller
 * updates the view when the model changes.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
namespace Quadigital\Database\Query;

use Quadigital\Database\AbstractDbModel;
use Quadigital\Database\DbAdapter\AbstractAdapter;
use Quadigital\Database\Query\Grammar\Grammar;

/**
 * This file contains a simple abstract controller class. This will be used by all of the modules that are used in the
 * application. The controller is the decision maker and the glue between the model and view. The controller
 * updates the view when the model changes.
 *
 * PHP version 5
 *
 * @author    Adam Rivers <contact@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class Builder
{

    /**
     * @var null|\Quadigital\DatabaseNew\DbAdapter\PDO
     */
    private $_connection = null;
    private $_grammar = null;
    private $_dbModel = null;

    public $from = null;
    public $limit;
    public $columns = null;
    public $wheres = array();
    public $bindings = array();
    public $aggregate = null;
    public $ignoreNullRows = true;

    /**
     * All of the available clause operators.
     *
     * @var array
     */
    protected $operators = array(
        '=', '<', '>', '<=', '>=', '<>', '!=',
        'like', 'not like', 'between', 'ilike',
    );

    /**
     * Create a new query instance.
     *
     * @param AbstractAdapter $connection
     * @param string          $tableName
     * @param AbstractDbModel $dbModel
     */
    public function __construct(AbstractAdapter $connection, $tableName, AbstractDbModel $dbModel = null)
    {
        $this->_connection = $connection;
        $this->_dbModel = $dbModel;
        $this->_grammar = new Grammar();

        $this->from = $tableName;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param string      $column
     * @param null|string $operator
     * @param null|string $value
     * @param string      $boolean
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        // If the given operator is not found in the list of valid operators we will
        // assume that the developer is just short-cutting the '=' operators and
        // we will set the operators to '=' and set the values appropriately.
        if ( ! in_array(strtolower($operator), $this->operators, true)) {
            list($value, $operator) = array($operator, '=');
        }

        // Now that we are working with just a simple query we can put the elements
        // in our array and add the query binding to our array of bindings that
        // will be bound to each SQL statements when it is finally executed.
        $type = 'Basic';

        $this->wheres[] = compact('type', 'column', 'operator', 'value', 'boolean');

        $this->bindings[] = $value;

        return $this;
    }

    /**
     * Add a basic sql where clause to the query.
     *
     * @param string      $sql
     * @param string      $boolean
     *
     * @return $this
     */
    public function whereSql($sql = null, $boolean = 'and')
    {
        // Now that we are working with just a simple query we can put the elements
        // in our array and add the query binding to our array of bindings that
        // will be bound to each SQL statements when it is finally executed.
        $type = 'Sql';

        $this->wheres[] = compact('type', 'sql', 'boolean');

        return $this;
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param int $value
     *
     * @return Query|static
     */
    public function limit($value)
    {
        if ($value > 0) {
            $this->limit = $value;
        }

        return $this;
    }

    /**
     * Select data from the database.
     *
     * @param array $columns
     *
     * @return array
     */
    public function select($columns = array('*'))
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();

        $result = $this->_connection->query($this->_grammar->compileSelect($this), $this->bindings);

        if ($result === null) {
            return array();
        }

        $result = $result->fetchAll();

        if ($this->_dbModel !== null) {
            $dbModelResults = array();

            foreach ($result as $row) {
                $tempDbModel = clone $this->_dbModel;
                $tempDbModel->exchangeArray($row);
                $dbModelResults[] = $tempDbModel;
            }

            return $dbModelResults;
        }

        return $result;
    }

    /**
     * Select data from the database.
     *
     * @param array $columns
     *
     * @return array
     */
    public function retrieve($columns = array('*'))
    {
        /** @var Query $selectResult */
        $selectResult = $this->select($columns);

        if (!is_array($selectResult) || count($selectResult) !== 1) {
            return null;
        }

        return reset($selectResult);
    }

    /**
     * Retrieve the "count" result of the query.
     *
     * @param array $column
     *
     * @return int
     */
    public function count($column = array('*'))
    {
        $sql = $this->_grammar->compileCount($this, $column);

        $results = $this->_connection->query($sql, $this->bindings);

        if ($results === false || $results === null) {
            return null;
        }
        $results = $results->fetchAll();

        if (isset($results[0])) {
            $result = (array) $results[0];

            return $result[0];
        }

        return null;
    }

    /**
     * Insert a new record into the database.
     *
     * @param array $values
     *
     * @return bool
     */
    public function insert(array $values = array())
    {
        if (count($values === 0) && isset($this->_dbModel)) {
            $values = $this->_dbModel->toArray($this->ignoreNullRows);
        }

        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient for building these
        // inserts statements by verifying the elements are actually an array.
        if ( ! is_array(reset($values))) {
            $values = array($values);
        }

        $bindings = array();

        // We'll treat every insert like a batch insert so we can easily insert each
        // of the records into the database consistently. This will make it much
        // easier on the grammars to just handle one type of record insertion.
        foreach ($values as $record) {
            $bindings = array_merge($bindings, array_values($record));
        }

        $sql = $this->_grammar->compileInsert($this, $values);

        // Once we have compiled the insert statement's SQL we can execute it on the
        // connection and return a result as a boolean success indicator as that
        // is the same type of result returned by the raw connection instance.

        $result = $this->_connection->query($sql, $bindings);

        return $result;
    }

    /**
     * Insert a new record into the database.
     *
     * @param array $values
     *
     * @return bool
     */
    public function insertGetId(array $values = array())
    {
        $this->insert($values);

        return $this->_connection->getConnection()->lastInsertId();
    }

    /**
     * Update a record in the database.
     *
     * @param  array  $values
     * @return int
     */
    public function update(array $values = array())
    {
        if (count($values === 0) && isset($this->_dbModel)) {
            $values = $this->_dbModel->toArray($this->ignoreNullRows);
        }

        $bindings = array_values(array_merge($values, $this->bindings));

        return $this->_connection->query($this->_grammar->compileUpdate($this, $values), $bindings);
    }

    /**
     * Delete a record from the database.
     *
     * @param mixed $id
     *
     * @return int
     */
    public function delete($id = null)
    {
        // If an ID is passed to the method, we will set the where clause to check
        // the ID to allow developers to simply and quickly remove a single row
        // from their database without manually specifying the where clauses.
        if ( ! is_null($id)) {
            $this->where('id', '=', $id);
        }

        $result = $this->_connection->query($this->_grammar->compileDelete($this), $this->bindings);

        return $result;
    }

    /**
     * Run a truncate statement on the table.
     *
     * @return void
     */
    public function truncate()
    {
        foreach ($this->_grammar->compileTruncate($this) as $sql => $bindings) {
            $this->_connection->query($sql, $bindings);
        }
    }

    public function ignoreNullRows($bool) {
        if (is_bool($bool)) {
            $this->ignoreNullRows = $bool;
        }
    }
}