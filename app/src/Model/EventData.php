<?php

declare(strict_types=1);

namespace App\Model;

use DateTimeImmutable;

readonly class EventData
{
    public DateTimeImmutable $createdAt;

    public function __construct(
        public string $title,
        public string $data,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
    ) {
        $this->createdAt = $createdAt;
    }
}