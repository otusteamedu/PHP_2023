<?php

declare(strict_types=1);

namespace Twent\Hw12\DTO;

final class Event
{
    public function __construct(
        /** @var positive-int */
        private readonly int $priority,
        private readonly Conditions $conditions,
        private readonly EventData $data
    ) {
    }

    public function __get(string $name)
    {
        return $this->{$name};
    }
}
