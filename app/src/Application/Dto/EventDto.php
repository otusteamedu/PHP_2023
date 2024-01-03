<?php

namespace App\Application\Dto;

final class EventDto
{
    public function __construct(private readonly int $priority, private readonly string $name)
    {
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
