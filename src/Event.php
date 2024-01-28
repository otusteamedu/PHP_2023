<?php

declare(strict_types=1);

namespace Dimal\Hw12;

class Event
{
    private EventConditions $conditions;
    private string $event;
    private int $priority;

    public function __construct(EventConditions $conditions, string $event, int $priority)
    {
        $this->conditions = $conditions;
        $this->event = $event;
        $this->priority = $priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getEventString()
    {
        return json_encode(['conditions' => $this->conditions->getConditions(), 'event' => $this->event]);
    }
}
