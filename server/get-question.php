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


try {
    $connection = DatabaseConnection::getConnection();

    $query = "SELECT * FROM question";

    $statement = $connection->query($query);
    $questions = $statement->fetchAll(\PDO::FETCH_ASSOC);

} catch (Throwable $throwable) {
    $http->displayResponse(500, "Application error");
}


$response = [
    'questions' => $questions
];

$http->displayResponse(200, $response);




