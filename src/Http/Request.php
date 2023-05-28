<?php

declare(strict_types=1);

namespace Otus\App\Http;

final readonly class Request
{
    public function __construct(
        private string $payload,
    ) {
    }

    public function getPayload(): string
    {
        return $this->payload;
    }
}
