<?php

namespace App\MediaPost\Config;

use App\MediaPost\Config\Constants as Constants;
use \PDO;

class Database
{
    static private $conn;
    private $count;
    
    public static function getConnection()
    {
        if (!self::$conn) {
            $conectionString = "mysql:host=".Constants::HOSTNAME_DB.";dbname=".Constants::DB_NAME;
            self::$conn = new \PDO(
                    $conectionString,
                    Constants::USERNAME_DB, 
                    Constants::PASSWORD_USER_DB
            );
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_CLASS);
        }
        return self::$conn;
    }

}