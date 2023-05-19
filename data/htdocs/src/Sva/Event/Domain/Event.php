<?php

namespace Sva\Event\Domain;

class Event
{
    private int $priority;
    private array $conditions;
    private array $event = [];

    /**
     * @param int $priority
     * @param array $conditions
     * @param array $event
     */
    public function __construct(int $priority, array $conditions, array $event)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return array
     */
    public function getEvent(): array
    {
        return $this->event;
    }
}
