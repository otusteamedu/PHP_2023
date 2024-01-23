<?php

declare(strict_types=1);

namespace App;

class EventFilter
{
    public static function filterEventsBySources(array $events, int $sourceMask): array
    {
        $filteredEvents = [];
        foreach ($events as $event) {
            $eventSourceMask = SourceMask::calculateMaskFromSources($event->getSource());
            if (($eventSourceMask & $sourceMask) === $sourceMask) {
                $filteredEvents[] = $event;
            }
        }
        return $filteredEvents;
    }
}
