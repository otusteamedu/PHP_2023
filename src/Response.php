<?php

declare(strict_types=1);

namespace Root\App;

class Response
{
    public static function echo(bool $status, ?string $message, mixed $data = null): void
    {
        header('Content-Type: application/json');
        http_response_code($status ? 200 : 500);
        echo json_encode(['status' => $status, 'message' => $message, 'data' => $data], JSON_UNESCAPED_UNICODE);
    }
}
