<?php

use App\database\DatabaseConnection;
use GuzzleHttp\Exception\GuzzleException;
require '../vendor/autoload.php';
require_once "database/DatabaseConnection.php";
require_once "JsonResponse.php";
header("Content-Type: application/json");


$headers = getallheaders();
$http = new jsonResponse();
if (!isset($headers["Authorization"])) {
    $http->displayResponse(401, "Invalid token");
}

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
  $http->displayResponse(500, "Application Error");
}

$http->displayResponse(200, "Success");



