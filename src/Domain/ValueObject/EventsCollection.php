<?php

namespace App\Domain\ValueObject;

use App\Domain\Entity\Event;

class EventsCollection
{
    /** @var Event[] */
    private array $events;

    public function __construct(Event ...$events)
    {
        $this->events = $events;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}