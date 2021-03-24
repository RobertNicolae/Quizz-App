<?php

use App\database\DatabaseConnection;

require_once "database/DatabaseConnection.php";
require_once "instance.php";
header("Content-Type: application/json");

$http = new instance();
try {
    $connection = DatabaseConnection::getConnection();
    $query = "UPDATE answer SET is_right = 0 where question_id = :question_id";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        ":question_id" => $_REQUEST["question_id"]
    ]);

    $query = "UPDATE answer SET is_right = 1 WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        ":id" => $_REQUEST["id"]
    ]);

} catch (Throwable $throwable) {
  $http->getCode(500, "Application Error");
}

$http->getCode(200, "Success");



