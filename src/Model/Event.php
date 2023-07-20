<?php

namespace App\Model;

class Event
{
    private $priority;
    private $conditions;
    private $event;

    public function __construct(int $priority, array $conditions, $event)
    {
        $this->priority = $priority;
        $this->conditions = $conditions;
        $this->event = $event;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function matchesParams(array $params): bool
    {
        foreach ($this->conditions as $key => $value) {
            if (!isset($params[$key]) || $params[$key] != $value) {
                return false;
            }
        }

        return true;
    }

    public function getEvent()
    {
        return $this->event;
    }
}
