<?php

declare(strict_types=1);

namespace Gesparo\HW\Event;

class Event
{
    public const PRIORITY = 'priority';
    public const CONDITIONS = 'conditions';
    public const EVENT = 'event';

    private array $data;

    public function __construct(array $data)
    {
        $this->assertValidEvent($data);
        $this->data = $data;
    }

    private function assertValidEvent(array $data): void
    {
        if (!isset($data[self::PRIORITY])) {
            throw new \InvalidArgumentException('Priority is not set');
        }

        if (!isset($data[self::CONDITIONS])) {
            throw new \InvalidArgumentException('Conditions is not set');
        }

        if (!is_array($data[self::CONDITIONS])) {
            throw new \InvalidArgumentException('Conditions must be array');
        }

        if (!isset($data[self::EVENT])) {
            throw new \InvalidArgumentException('Event is not set');
        }
    }

    public function getPriority(): int
    {
        return $this->data[self::PRIORITY];
    }

    public function getConditions(): array
    {
        return $this->data[self::CONDITIONS];
    }

    public function getEvent(): string
    {
        return $this->data[self::EVENT];
    }
}
