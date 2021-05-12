<?php


class jsonResponseAuth
{
protected int $code;
protected string $message;

public function displayResponse($code, $message): void
{

    http_response_code($code);
    echo json_encode([
        "message" => $message
    ]);
    die();
}
}
