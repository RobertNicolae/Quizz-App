<?php

use App\database\DatabaseConnection;
use GuzzleHttp\Exception\GuzzleException;
require '../vendor/autoload.php';
require_once "database/DatabaseConnection.php";
require_once "JsonResponse.php";
header("Content-Type: application/json");



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
$name = $_REQUEST["question_name"];

if(!isset($name) || !strlen(trim($name))) {
   $http->displayResponse(400, "Invalid question name");
}

try {
    $conn = DatabaseConnection::getConnection();
    $query = "INSERT INTO question (name) VALUES (:name);";

    $statement = $conn->prepare($query);
    $statement->execute([
        ":name" => $name
    ]);
} catch (Throwable $throwable) {
    $http->displayResponse(500, "Application error");
}


$http->displayResponse(200, "Success");



