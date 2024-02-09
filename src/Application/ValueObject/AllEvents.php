<?php

namespace App\Application\ValueObject;

use App\Domain\Entity\Event;

class AllEvents
{
    private array $events;

    public function __construct(array $events)
    {
        foreach ($events as $event) {
            if (!$event instanceof Event) {
                throw new \InvalidArgumentException('All elements of $events must be instances of Event');
            }
        }

        $this->events = $events;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}