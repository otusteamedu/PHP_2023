<?php

namespace App\Domain\DTO;

use App\Domain\ValueObject\EventsCollection;
use App\Domain\ValueObject\SourceMask;

class EventSourcesDTO
{
    private SourceMask $sourceMask;
    private EventsCollection $eventsCollection;

    public function __construct(SourceMask $sourceMask, EventsCollection $eventsCollection)
    {
        $this->sourceMask = $sourceMask;
        $this->eventsCollection = $eventsCollection;
    }

    public function getSourceMask(): SourceMask
    {
        return $this->sourceMask;
    }

    public function getEventsCollection(): EventsCollection
    {
        return $this->eventsCollection;
    }
}