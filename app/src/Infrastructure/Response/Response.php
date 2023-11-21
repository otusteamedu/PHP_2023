<?php

namespace App\Infrastructure\Response;

class Response implements ResponseInterface
{
    private int $code;
    private string $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function toJson(): string
    {
        $response = [
            "message" => $this->message
        ];
        http_response_code($this->code);

        return json_encode($response);
    }
}
