<?php

declare(strict_types=1);

namespace Otus\App\Http;

final readonly class Response
{
    public function __construct(
        private int $httpCode,
        private string $httpContent,
    ) {
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getHttpContent(): string
    {
        return $this->httpContent;
    }
}
