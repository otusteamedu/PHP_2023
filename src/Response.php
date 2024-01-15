<?php

declare(strict_types=1);

namespace Santonov\Otus;

final class Response
{
    public function __construct(
        private readonly string $message,
        int $responseCode,
    ) {
        http_response_code($responseCode);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
