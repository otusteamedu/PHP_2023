<?php

declare(strict_types=1);

namespace Ro\Php2023\Entities;

use Ro\Php2023\Collections\ConditionsInterface;

class Event implements EventInterface
{
    public function __construct(
        private readonly int $priority,
        private readonly ConditionsInterface $conditions,
        private readonly array $event,
    ) {
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): ConditionsInterface
    {
        return $this->conditions;
    }

    public function getEvent(): array
    {
        return $this->event;
    }
}
