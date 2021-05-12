<?php

use App\database\DatabaseConnection;
use GuzzleHttp\Exception\GuzzleException;
require '../vendor/autoload.php';
require_once "database/DatabaseConnection.php";
require_once "JsonResponse.php";


$headers = getallheaders();
$http = new jsonResponse();


$token = $headers["Authorization"];
$client = new GuzzleHttp\Client();

try {
    $res = $client->request('POST', 'http://localhost/Auth/server/CheckToken.php', [
        'form_params' => [
            'token' => $token
        ],
        'headers' => [
            "Authorization" => $token
        ]
    ]);

} catch (GuzzleException $exception) {
    $http->displayResponse(401, "Neautorizat");
} catch (Throwable $throwable) {
    $http->displayResponse(500, "Application error");
}

header("Content-Type: application/json");
$http = new jsonResponse();
if (!isset($_REQUEST["answer_name"]) || !strlen(trim($_REQUEST["answer_name"]))) {
    $http->displayResponse(400, "Invalid name");

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


$http = new jsonResponse();
$http->displayResponse(200, "Successs");

