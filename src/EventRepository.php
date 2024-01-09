<?php

declare(strict_types=1);

namespace App;

use Predis\Client;

class EventRepository
{
    private Client $redisClient;

    public function __construct(RedisClient $redisClient)
    {
        $this->redisClient = $redisClient->getClient();
    }

    public function getAllEvents(): array
    {
        $eventsData = $this->redisClient->zRevRange('events', 0, -1);
        $events = [];
        foreach ($eventsData as $eventJson) {
            $events[] = Event::fromJson($eventJson);
        }
        return $events;
    }
}
