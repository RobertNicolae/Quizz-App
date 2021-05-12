<?php


namespace App\Auth\Database;


class database
{
    protected static ?\PDO $connection = null;


    public static function getConnection(): \PDO {

        if(!self::$connection) {
            self::$connection = new \PDO('mysql:host=localhost;dbname=login', 'root');
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}