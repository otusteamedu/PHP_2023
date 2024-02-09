<?php

declare(strict_types=1);

namespace App;

use App\Application\DTO\EventFilterDTO;
use App\Application\EventService;
use App\Application\ValueObject\AllEvents;
use App\Application\ValueObject\SourceNames;
use App\Domain\EventFilter;
use App\Infrastructure\RedisClient;
use App\Infrastructure\RedisEventRepository;

class App
{
    public function run($argv)
    {
        $redisClient = new RedisClient();
        $eventRepository = new RedisEventRepository($redisClient);
        $eventFilter = new EventFilter();
        $eventService = new EventService($eventFilter);

        $allEvents = $eventRepository->getAllEvents();

        if (count($argv) > 1) {
            $sourceNames = array_slice($argv, 1);
            $sourceNamesVO = new SourceNames($sourceNames);
            $allEventsVO = new AllEvents($allEvents);

            $eventFilterDto = new EventFilterDTO($sourceNamesVO, $allEventsVO);

            return $eventService->getFilteredEvents($eventFilterDto);
        } else {
            echo "Использование: php index.php [источники]\n";
        }
    }
}
