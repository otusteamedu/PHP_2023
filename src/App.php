<?php

declare(strict_types=1);

namespace App;

class App
{
    public function run($argv)
    {
        $redisClient = new RedisClient();
        $eventRepository = new EventRepository($redisClient);

        $allEvents = $eventRepository->getAllEvents();

        if (count($argv) > 1) {
            $sourceNames = array_slice($argv, 1);
            $sourceMask = SourceMask::calculateMaskFromNames($sourceNames);
            return EventFilter::filterEventsBySources($allEvents, $sourceMask);
        } else {
            echo "Использование: php index.php [источники]\n";
        }
    }
}
