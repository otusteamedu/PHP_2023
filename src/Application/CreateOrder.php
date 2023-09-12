<?php

declare(strict_types=1);

namespace App\Application;

use Symfony\Component\Uid\Ulid;

final readonly class CreateOrder
{
    public function __construct(
        private Ulid $ulid,
        private string $body,
    ) {
    }

    public function getUlid(): Ulid
    {
        return $this->ulid;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
