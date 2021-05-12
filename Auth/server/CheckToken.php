<?php

use App\Auth\Database\database;

require_once "JsonResponseAuth.php";
require_once "database.php";
header("Content-Type: application/json");



$http = new jsonResponse();
if (!isset($_REQUEST["token"]) || !strlen(trim($_REQUEST["token"]))) {
 $http->displayResponse(400, "Invalid token");

}


try {
    $connection = database::getConnection();
    $query = "SELECT token from user WHERE token = :token";
    $stmt = $connection->prepare($query);
    $stmt->execute([
       "token" => $_REQUEST["token"]
    ]);
    $token = $stmt->fetch(PDO::FETCH_ASSOC); //fetch to treat only an element, instead of the entire list of rows
    if (!$token) {
        $http->displayResponse(401, "Invalid token");
    }

} catch (Throwable $throwable) {
    $http->displayResponse(500, "Application error");
}

$http->displayResponse(200, "Success");

