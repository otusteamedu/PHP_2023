<?php

declare(strict_types=1);

namespace App;

class EventFilter
{
    public static function filterEventsBySources(array $allEvents, int $sourceMask, array $sources): array
    {
        $filteredEvents = [];
        foreach ($allEvents as $eventJson) {
            $event = json_decode($eventJson, true);
            $eventSourceMask = SourceMask::calculateMaskFromSources($event['source'], $sources);
            if (($eventSourceMask & $sourceMask) === $sourceMask) {
                $filteredEvents[] = $event;
            }
        }
        return $filteredEvents;
    }
}
