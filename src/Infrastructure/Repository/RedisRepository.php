<?php

declare(strict_types=1);

namespace src\Infrastructure\Repository;

use Predis\Client;
use src\Application\Repository\RepositoryInterface;
use src\Domain\Event;

class RedisRepository implements RepositoryInterface
{
    private Client $client;
    const KEY = 'events:priority:';

    public function __construct()
    {
        $host = 'redis';
        $port = 6379;
        $connectionParameters = sprintf(
            '%s://%s:%s',
            'tcp',
            $host,
            $port
        );
        $this->client = new Client($connectionParameters);
    }

    public function addNewEvent(Event $event): void
    {
        $jsonEvent = json_encode([
            'priority' => $event->getPriority(),
            'param1' => $event->getConditions()->getParam1(),
            'param2' => $event->getConditions()->getParam2(),
            'event' => $event->getEvent()
        ]);

        $this->client->zadd(
            self::KEY
            . $event->getConditions()->getParam1()
            . ':' . $event->getConditions()->getParam2(),
            [
                $jsonEvent => $event->getPriority()
            ]
        );
    }

    public function clearAllEvent(): void
    {
        $keys = $this->client->keys('*');
        if ($keys) {
            $this->client->del($keys);
        }
    }

    public function getByParameters(?int $param1 = null, ?int $param2 = null): ?Event
    {
        $response = $this->client->zrange(self::KEY . "$param1:$param2", -1, -1);

        if (!$response) {
            return null;
        }

        $redisEvent = json_decode($response[0], true);

        return new Event(
            priority: $redisEvent['priority'],
            event: $redisEvent['event'],
            conditions: [
                'param1' => isset($redisEvent['param1']) ? (int)$redisEvent['param1'] : null,
                'param2' => isset($redisEvent['param2']) ? (int)$redisEvent['param2'] : null
            ]
        );
    }
}
