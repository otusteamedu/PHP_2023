<?php

declare(strict_types=1);

namespace Twent\Hw12\DTO;

use DateTimeInterface;

final class EventData
{
    public function __construct(
        /** @var non-empty-string */
        private readonly string $title,
        private readonly DateTimeInterface $date,
        private readonly string $description
    ) {
    }
}
