<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Dto;

final class EventDataDto
{
    public function __construct(
        public readonly string $type,
        public readonly string $name,
        public readonly \DateTimeInterface $dateTime,
    ) {
    }
}
