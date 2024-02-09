<?php

namespace App\Application;

use App\Application\DTO\EventFilterDTO;
use App\Domain\Contract\EventFilterInterface;
use App\Domain\DTO\EventSourcesDTO;
use App\Domain\SourceMaskHandler;
use App\Domain\ValueObject\EventsCollection;
use App\Domain\ValueObject\SourceMask;

class EventService
{
    private EventFilterInterface $eventFilter;

    public function __construct(EventFilterInterface $eventFilter)
    {
        $this->eventFilter = $eventFilter;
    }

    public function getFilteredEvents(EventFilterDTO $eventFilterDto): array
    {
        $sourceMask = SourceMaskHandler::calculateMaskFromNames($eventFilterDto->getSourceNames()->getNames());

        $sourceMaskVO = new SourceMask($sourceMask);
        $eventsVO = new EventsCollection($eventFilterDto->getAllEvents()->getEvents());

        $eventSourcesDTO = new EventSourcesDTO($sourceMaskVO, $eventsVO);

        return $this->eventFilter->filterEventsBySources($eventSourcesDTO);
    }
}