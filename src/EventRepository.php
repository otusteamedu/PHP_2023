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
        return $this->redisClient->zRevRange('events', 0, -1);
    }
}
