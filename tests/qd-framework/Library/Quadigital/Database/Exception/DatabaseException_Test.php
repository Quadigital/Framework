<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

class DatabaseException_Test extends PHPUnit_Framework_TestCase
{
    public function test_databaseException()
    {
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException');

        throw new \Quadigital\Database\Exception\DatabaseException();
    }

    public function test_databaseExceptionMessage()
    {
        $message = 'This is a database exception message test.';
        $this->setExpectedException('\Quadigital\Database\Exception\DatabaseException', $message);

        throw new \Quadigital\Database\Exception\DatabaseException($message);
    }
}
