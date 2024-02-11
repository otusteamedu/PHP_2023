<?php
declare(strict_types=1);

namespace WorkingCode\Hw12\DTO;

use JsonSerializable;

class EventDTO implements JsonSerializable
{
    private ?int   $priority;
    private ?array $conditions;

    private ?array $event;

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getEvent(): array
    {
        return $this->event;
    }

    public function setEvent(array $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'priority'   => $this->priority,
            'conditions' => $this->conditions,
            'event'      => $this->event,
        ];
    }
}
