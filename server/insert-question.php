<?php

use App\database\DatabaseConnection;

require_once "database/DatabaseConnection.php";
require_once "instance.php";
header("Content-Type: application/json");

$http = new instance();
$name = $_REQUEST["question_name"];
if(!isset($name) || !strlen(trim($name))) {
   $http->getCode(400, "Invalid question name");
}

try {
    $conn = DatabaseConnection::getConnection();
    $query = "INSERT INTO question (name) VALUES (:name);";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":name" => $name
    ]);
} catch (Throwable $throwable) {
    $http->getCode(500, "Application error");
}


$http->getCode(200, "Success");



