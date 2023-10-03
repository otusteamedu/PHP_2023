<?php

declare(strict_types=1);

namespace Eevstifeev\Hw12\Models;

use Ramsey\Uuid\Uuid;

class Event
{
    private string $uuid;
    private int $priority;
    private array $conditions;
    private string $event;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getUuid(): string
    {
        return $this->uuid;
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

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'priority' => $this->priority,
            'conditions' => json_encode($this->conditions),
            'event' => $this->event,
        ];
    }

    public function fromArray(array $data): void
    {
        $this->uuid = $data['uuid'];
        $this->priority = (int)$data['priority'];
        $this->conditions = json_decode($data['conditions'], true);
        $this->event = $data['event'];
    }
}
