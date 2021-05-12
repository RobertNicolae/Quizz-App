<?php


require_once "database.php";
header("Content-Type: application/json");

if (!isset($_REQUEST["email"]) || !strlen(trim($_REQUEST["email"]))) {
    http_response_code(400);
    echo json_encode([
        "message" => "Invalid email"
    ]);
    die();

}
if (!isset($_REQUEST["password"]) || !strlen(trim($_REQUEST["password"]))) {
    http_response_code(400);
    echo json_encode([
        "message" => "Invalid password"
    ]);
    die();

}
$connection = App\Auth\Database\database::getConnection();
try {

    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    $query = "SELECT token FROM user WHERE email = :email && PASSWORD = :password; ";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        "email" => $email,
        "password" => $password
    ]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($data)) {
        throw new Exception("Invalid");
    }



} catch (Throwable $throwable) {
    http_response_code(500);
    echo json_encode([
        "message" => "Application error"
    ]);
    die();

}



http_response_code(200);
echo json_encode([
    "data" => $data
]);
die();

