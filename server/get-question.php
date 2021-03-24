<?php

use App\database\DatabaseConnection;

require_once "database/DatabaseConnection.php";
require_once "instance.php";
header("Content-Type: application/json");

$http = new instance();
try {
    $connection = DatabaseConnection::getConnection();

    $query = "SELECT * FROM question";

    $statement = $connection->query($query);
    $questions = $statement->fetchAll(PDO::FETCH_ASSOC);

} catch (Throwable $throwable) {
 $http->getCode(500, "Application error");
}


$response = [
    'questions' => $questions
];

$http->getCode(200, $response);