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
namespace Quadigital\Database\Query\Grammar;

use Quadigital\Database\Query\Builder;

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
class Grammar
{

    /**
     * The keyword identifier wrapper format.
     *
     * @var string
     */
    protected $wrapper = '`%s`';

    /**
     * The components that make up a select clause.
     *
     * @var array
     */
    protected $selectComponents = array(
        'columns',
        'from',
        'wheres',
        'limit',
    );

    /**
     * Compile a select query into SQL.
     *
     * @param Builder $query
     *
     * @return string
     */
    public function compileSelect(Builder $query)
    {
        if ($query->columns === null || !is_array($query->columns) || count($query->columns) === 0) {
            $query->columns = array('*');
        }

        return trim($this->concatenate($this->compileComponents($query)));
    }

    /**
     * Compile the components necessary for a select clause.
     *
     * @param Builder $query
     *
     * @return array
     */
    protected function compileComponents(Builder $query)
    {
        $sql = array();

        foreach ($this->selectComponents as $component) {
            // To compile the query, we'll spin through each component of the query and
            // see if that component exists. If it does we'll just call the compiler
            // function for the component which is responsible for making the SQL.
            if ($query->$component !== null) {
                $method = 'compile' . ucfirst($component);

                $sql[$component] = $this->$method($query->$component);
            }
        }

        return $sql;
    }

    /**
     * Compile the "select *" portion of the query.
     *
     * @param array $columns
     *
     * @return string
     */
    protected function compileColumns(array $columns)
    {
        return 'SELECT ' . $this->columnize($columns);
    }

    /**
     * Compile the "from" portion of the query.
     *
     * @param string $table
     *
     * @return string
     */
    protected function compileFrom($table)
    {
        return 'FROM ' . $table;
    }

    /**
     * Concatenate an array of segments, removing empties.
     *
     * @param array $segments
     *
     * @return string
     */
    protected function concatenate($segments)
    {
        return implode(
            ' ',
            array_filter(
                $segments, function ($value) {
                    return (string)$value !== '';
                }
            )
        );
    }

    /**
     * Compile the "where" portions of the query.
     *
     * @param array $wheres
     *
     * @return string
     */
    public function compileWheres($wheres)
    {
        $sql = array();

        if ($wheres === null) {
            return '';
        }

        // Each type of where clauses has its own compiler function which is responsible
        // for actually creating the where clauses SQL. This helps keep the code nice
        // and maintainable since each clause has a very small method that it uses.
        foreach ($wheres as $where) {
            $method = "where{$where['type']}";

            $sql[] = $where['boolean'] . ' ' . $this->$method($where);
        }

        // If we actually have some where clauses, we will strip off the first boolean
        // operator, which is added by the query builders for convenience so we can
        // avoid checking for the first clauses in each of the compilers methods.
        if (count($sql) > 0) {
            $sql = implode(' ', $sql);

            return 'WHERE ' . preg_replace('/and |or /', '', $sql, 1);
        }

        return '';
    }

    /**
     * Compile a basic where clause.
     *
     * @param array $where
     *
     * @return string
     */
    protected function whereBasic($where)
    {
        $value = $this->parameter();

        return $where['column'] . ' ' . $where['operator'] . ' ' . $value;
    }

    /**
     * Compile a basic where clause.
     *
     * @param array $where
     *
     * @return string
     */
    protected function whereSql($where)
    {
        return $where['sql'];
    }

    /**
     * Compile an insert statement into SQL.
     *
     * @param Builder $query
     * @param array $values
     *
     * @return string
     */
    public function compileInsert(Builder $query, array $values)
    {
        // Essentially we will force every insert to be treated as a batch insert which
        // simply makes creating the SQL easier for us since we can utilize the same
        // basic routine regardless of an amount of records given to us to insert.
        $table = $query->from;

        if (!is_array(reset($values))) {
            $values = array($values);
        }

        $columns = $this->columnize(array_keys(reset($values)));

        // We need to build a list of parameter place-holders of values that are bound
        // to the query. Each insert should have the exact same amount of parameter
        // bindings so we can just go off the first list of values in this array.
        $parameters = $this->parameterize(reset($values));

        $value = array_fill(0, count($values), "($parameters)");

        $parameters = implode(', ', $value);

        return "insert into $table ($columns) values $parameters";
    }

    /**
     * Compile a truncate table statement into SQL.
     *
     * @param Builder $query
     *
     * @return array
     */
    public function compileTruncate(Builder $query)
    {
        return array('truncate ' . $this->wrapTable($query->from) => array());
    }

    /**
     * Compile a delete statement into SQL.
     *
     * @param Builder $query
     *
     * @return string
     */
    public function compileDelete(Builder $query)
    {
        $table = $this->wrapTable($query->from);

        $where = is_array($query->wheres) ? $this->compileWheres($query->wheres) : '';

        return trim("delete from $table " . $where);
    }

    /**
     * Get the appropriate query parameter place-holder for a value.
     *
     * @return string
     */
    public function parameter()
    {
        return '?';
    }

    /**
     * Wrap a table in keyword identifiers.
     *
     * @param string $table
     *
     * @return string
     */
    public function wrapTable($table)
    {
        return $this->wrap($table);
    }

    /**
     * Wrap a value in keyword identifiers.
     *
     * @param string $value
     *
     * @return string
     */
    public function wrap($value)
    {
        if (preg_match('/\s/',$value)) {
             return $value; // No possible reason i can think of you would have whitespace in a val you want to wrap.
        }

        // If the value being wrapped has a column alias we will need to separate out
        // the pieces so we can wrap each of the segments of the expression on it
        // own, and then joins them both back together with the "as" connector.
        if (strpos(strtolower($value), ' as ') !== false) {
            $segments = explode(' ', $value);

            return $this->wrap($segments[0]) . ' as ' . $this->wrap($segments[2]);
        }

        $wrapped = array();

        $segments = explode('.', $value);

        // If the value is not an aliased table expression, we'll just wrap it like
        // normal, so if there is more than one segment, we will wrap the first
        // segments as if it was a table and the rest as just regular values.
        foreach ($segments as $key => $segment) {
            if ($key == 0 and count($segments) > 1) {
                $wrapped[] = $this->wrapTable($segment);
            } else {
                $wrapped[] = $this->wrapValue($segment);
            }
        }

        return implode('.', $wrapped);
    }

    /**
     * Wrap a single string in keyword identifiers.
     *
     * @param string $value
     *
     * @return string
     */
    protected function wrapValue($value)
    {
        return $value !== '*' ? sprintf($this->wrapper, $value) : $value;
    }

    /**
     * Convert an array of column names into a delimited string.
     *
     * @param array $columns
     *
     * @return string
     */
    public function columnize(array $columns)
    {
        return implode(', ', array_map(array($this, 'wrap'), $columns));
    }

    /**
     * Compile the "limit" portions of the query.
     *
     * @param string $limit
     *
     * @return string
     */
    protected function compileLimit($limit)
    {
        return "limit $limit";
    }

    /**
     * Compile an count clause.
     *
     * @param Builder $query
     * @param array $columns
     *
     * @return string
     */
    public function compileCount(Builder $query, $columns)
    {
        $column = $this->columnize($columns);

        $where = is_array($query->wheres) ? $this->compileWheres($query->wheres) : '';

        return 'select count(' . $column . ') from ' . $query->from . ' ' . $where;
    }

    /**
     * Create query parameter place-holders for an array.
     *
     * @param array $values
     *
     * @return string
     */
    public function parameterize(array $values)
    {
        return implode(', ', array_map(array($this, 'parameter'), $values));
    }

    /**
     * Compile an update statement into SQL.
     *
     * @param  Builder  $query
     * @param  array  $values
     * @return string
     */
    public function compileUpdate(Builder $query, $values)
    {
        $table = $this->wrapTable($query->from);

        // Each one of the columns in the update statements needs to be wrapped in the
        // keyword identifiers, also a place-holder needs to be created for each of
        // the values in the list of bindings so we can make the sets statements.
        $columns = array();

        foreach ($values as $key => $value)
        {
            $columns[] = $this->wrap($key).' = '.$this->parameter($value);
        }

        $columns = implode(', ', $columns);

        // Of course, update queries may also be constrained by where clauses so we'll
        // need to compile the where clauses and attach it to the query so only the
        // intended records are updated by the SQL statements we generate to run.
        $where = $this->compileWheres($query->wheres);

        return trim("update {$table} set $columns $where");
    }

}