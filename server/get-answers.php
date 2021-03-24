<?php

use App\database\DatabaseConnection;

require_once "database/DatabaseConnection.php";
require_once "instance.php";
header("Content-Type: application/json");

$http = new instance();
try {
    $connection = DatabaseConnection::getConnection();

    $query = "SELECT * FROM answer WHERE question_id = :question_id";

    $stmt = $connection->prepare($query);
    $stmt->execute([
        "question_id" => $_REQUEST["question_id"]
    ]);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $throwable) {
    $http->getCode(500, "Application Error");
}


$response = [
    'answers' => $answers
];

$http->getCode(200, $response);




