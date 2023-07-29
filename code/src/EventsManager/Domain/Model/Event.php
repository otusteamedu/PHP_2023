<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Domain\Model;

class Event
{
    private int $priority;
    private string $event;
    private array $conditions = [];

    public function __construct(string $event, int $priority, array $conditions)
    {
        $this->event = $event;
        $this->priority = $priority;
        $this->conditions = $conditions;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }
}
