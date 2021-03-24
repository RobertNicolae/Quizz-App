<?php

use App\database\DatabaseConnection;

require_once "database/DatabaseConnection.php";
require_once "instance.php";
header("Content-type: application/json");

$http = new instance();
try {

    $connection = DatabaseConnection::getConnection();

    $query = "DELETE FROM question WHERE id = :id";

    $stmt = $connection->prepare($query);
    $stmt->execute([
        "id" => $_REQUEST['id']
    ]);
} catch (Throwable $throwable) {
  $http->getCode(500, "Application Error");
}

$http->getCode(200, "Success");
