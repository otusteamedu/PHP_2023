<?php

declare(strict_types=1);

function generateResponse(int $code, string $message): void
{
    http_response_code($code);
    echo json_encode(['error' => $message]);
}