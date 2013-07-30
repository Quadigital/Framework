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
namespace Quadigital\Database\Exception;

/**
 * Class DatabaseException
 *
 * @package Quadigital\Database\Exception
 */
class DatabaseException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Database Exception';
}