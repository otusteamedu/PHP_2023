<?php

declare(strict_types=1);

namespace Vp\App\Models;

class Event
{
    private string $eventId;
    private int $priority;
    private array $conditions;
    private string $event;

    public function __construct(string $eventId, string $priority, array $conditions, string $event)
    {
        $this->eventId = $eventId;
        $this->priority = (int)$priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}
