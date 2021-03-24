<?php


class instance
{
protected int $code;
protected string $message;

public function getCode($code, $message): void
{

    http_response_code($code);
    echo json_encode([
        "message" => $message
    ]);
    die();
}
}
