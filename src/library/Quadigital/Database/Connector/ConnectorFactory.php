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

use Quadigital\Database\Exception\DatabaseException;
use Quadigital\Factory\Creator;

class ConnectorFactory extends Creator
{

    private $_rdbmsType = null;
    private $_options = array();

    public function __construct($rdbmsType, array $options = array())
    {
        $this->_rdbmsType = $rdbmsType;
        $this->_options = $options;
    }

    protected function factoryMethod()
    {
        /** @var ConnectorInterface $connector */
        $connector = null;

        switch($this->_rdbmsType) {
            case 'mysql':
                $connector = new MySqlConnector();
                break;
            default:
                throw new DatabaseException(ERROR_E00002);
                break;
        }

        if (!$connector instanceof Connector) {
            // Fail-safe in case connector wasn't set properly.
            throw new DatabaseException(ERROR_E00003);
        }

        return $connector->connect($this->_options);
    }

    // GETTERS AND SETTERS

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->_options = $options;
    }

    public function addOption($key, $value)
    {
        $this->_options[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param null $rdbmsType
     */
    public function setRdbmsType($rdbmsType)
    {
        $this->_rdbmsType = $rdbmsType;
    }

    /**
     * @return null
     */
    public function getRdbmsType()
    {
        return $this->_rdbmsType;
    }
}