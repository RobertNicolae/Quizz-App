<?php

use App\database\DatabaseConnection;

require_once "database/DatabaseConnection.php";
require_once "instance.php";

header("Content-Type: application/json");
$http = new instance();
if (!isset($_REQUEST["answer_name"]) || !strlen(trim($_REQUEST["answer_name"]))) {
    $http->getCode(400, "Invalid name");

}


if (!isset($_REQUEST["question_id"])) {
    http_response_code(400);
    echo json_encode([
        "message" => "Invalid id"
    ]);
    die();
}

$connection = DatabaseConnection::getConnection();

$stmt = $connection->prepare('INSERT INTO answer (name, is_right, question_id) VALUES (:name, :is_right, :question_id)');
$stmt->execute([
    ':name' => $_REQUEST['answer_name'],
    ':is_right' => 0,
    ':question_id' => $_REQUEST['question_id']
]);


$http = new instance();
$http->getCode(200, "Successs");

