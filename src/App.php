<?php

declare(strict_types=1);

namespace App;

class App
{
    const REDIS_CONFIG = [
        'scheme' => 'tcp',
        'host' => 'redis',
        'port' => 6379,
    ];

    const SOURCES = [
        'планер' => 1,
        'силовая установка' => 2,
        'шасси' => 4,
        'тормозная система' => 8,
        'бортовое оборудование' => 16,
    ];

    public function run($argv)
    {
        $redisClient = new RedisClient(self::REDIS_CONFIG);
        $eventRepository = new EventRepository($redisClient);

        $allEvents = $eventRepository->getAllEvents();

        if (count($argv) > 1) {
            $sourceNames = array_slice($argv, 1);
            $sourceMask = SourceMask::calculateMaskFromNames($sourceNames, self::SOURCES);
            return EventFilter::filterEventsBySources($allEvents, $sourceMask, self::SOURCES);
        } else {
            echo "Использование: php index.php [источники]\n";
        }
    }
}
