<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Contract\EventFilterInterface;
use App\Domain\DTO\EventSourcesDTO;

class EventFilter implements EventFilterInterface
{
    public static function filterEventsBySources(EventSourcesDTO $eventFilterDto): array
    {
        $filteredEvents = [];
        foreach ($eventFilterDto->getEventsCollection() as $event) {
            $eventSourceMask = SourceMaskHandler::calculateMaskFromSources($event->getSource());
            if (($eventSourceMask & $sourceMask) === $sourceMask) {
                $filteredEvents[] = $event;
            }
        }
        return $filteredEvents;
    }
}
