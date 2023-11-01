<?php

declare(strict_types=1);

namespace Gesparo\HW\Event;

class EventList implements \Iterator
{
    private array $events;
    private int $position = 0;

    public function __construct(array $events)
    {
        $this->assertValidEvents($events);
        $this->events = $events;
    }

    private function assertValidEvents(array $events): void
    {
        foreach ($events as $event) {
            if (!$event instanceof Event) {
                throw new \InvalidArgumentException('Event must be instance of Event');
            }
        }
    }

    public function current(): Event
    {
        return $this->events[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->events[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
