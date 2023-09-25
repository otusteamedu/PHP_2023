<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Response;

class Response
{
    protected int $status = 200;
    protected string $message = 'OK';

    const HTTP_CODE_OK = 200;
    const HTTP_CODE_BAD_REQUEST = 400;

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setStatusCode(int $status, string $message): void
    {
        $this->status = $status;
        $this->message = $message;
        http_response_code($status);
    }

    public function sendResponse(int $status, string $message): void
    {
        echo $message;
        http_response_code($status);
    }

    public static  function send(int $status, string $message): void
    {
        echo $message;
        http_response_code($status);
    }
}