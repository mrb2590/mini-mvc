<?php
/**
 * SQLTable.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Model;

class SQLTable
{
    /**
     * @var mysqli $mysqli  The mysqli object
     */
    protected $mysqli;

    /**
     * Instantiate the mysqli class. This requires the database credentials from mysqli.php
     */
    public function __construct()
    {
        $dbCreds = require DOC_ROOT . '/mysqli.php';
        $this->mysqli = new \mysqli(
            $dbCreds['host'],
            $dbCreds['user'],
            $dbCreds['pass'],
            $dbCreds['db']
        );
        if ($this->mysqli->connect_errno > 0) {
            throw new \Exception('Unable to connect to database [' . $this->mysqli->connect_error . ']');
        }
    }
}
