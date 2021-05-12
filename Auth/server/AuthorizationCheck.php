<?php

use App\Auth\Database\database;

require_once "database.php";
;

class AuthorizationCheck
{
    public function check(string $token): bool
    {
        $connection = database::getConnection();


        return true;
    }
}