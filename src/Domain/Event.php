<?php

declare(strict_types=1);

namespace src\Domain;

class Event
{
    private int $priority;
    private string $event;
    private Conditions $conditions;

    public function __construct(int $priority, string $event, array $conditions = [])
    {
        $this->priority = $priority;
        $this->event = $event;
        $this->conditions = new Conditions(
            param1: $conditions['param1'],
            param2: $conditions['param2']
        );
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getConditions(): Conditions
    {
        return $this->conditions;
    }
}
