<?php

namespace App\Application\DTO;

use App\Application\ValueObject\AllEvents;
use App\Application\ValueObject\SourceNames;

class EventFilterDTO
{
    public function __construct(
        private readonly SourceNames $sourceNames,
        private readonly AllEvents $allEvents
    ) {}

    public function getSourceNames(): SourceNames
    {
        return $this->sourceNames;
    }

    public function getAllEvents(): AllEvents
    {
        return $this->allEvents;
    }
}