<?php

namespace App\Domain;

readonly class QueueElement
{
    private ElementPriority $priority;
    private ElementConditions $conditions;
    private ElementEvent $event;

    public function __construct(
        int $priority,
        int $param1,
        int $param2,
        string $eventAlias
    ) {
        $this->priority = new ElementPriority($priority);
        $this->conditions = new ElementConditions($param1, $param2);
        $this->event = new ElementEvent($eventAlias);
    }

    public function getPriorityValue(): int
    {
        return $this->priority->getValue();
    }

    public function getConditionsParam1Value(): int
    {
        return $this->conditions->getParam1()->getValue();
    }

    public function getConditionsParam2Value(): int
    {
        return $this->conditions->getParam2()->getValue();
    }

    public function getEventValue(): string
    {
        return $this->event->getValue();
    }
}
