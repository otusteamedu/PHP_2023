<?php

namespace App\Infrastructure;

use App\Domain\Contract\EventRepositoryInterface;
use App\Domain\Entity\Event;

class RedisEventRepository implements EventRepositoryInterface
{
    private RedisClient $redisClient;

    public function __construct(RedisClient $redisClient)
    {
        $this->redisClient = $redisClient;
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