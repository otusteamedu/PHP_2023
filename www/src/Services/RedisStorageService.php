<?php

declare(strict_types=1);

namespace KhalikovDn\Hw12\Services;

use KhalikovDn\Hw12\Interface\RedisStorageInterface;
use Redis;

class RedisStorageService implements RedisStorageInterface
{
    private Redis $redisClient;
    private string $eventsKey = 'events';

    /**
     * @throws \RedisException
     */
    public function __construct($redisHost = 'redis', $redisPort = 6379, $redisDb = 0)
    {
        $this->redisClient = new Redis();
        $this->redisClient->connect($redisHost, $redisPort);
        $this->redisClient->select($redisDb);
    }

    /**
     * @throws \RedisException
     */
    public function add($priority, $conditions, $event): void
    {
        $event = [
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event,
        ];

        $this->redisClient->rpush($this->eventsKey, json_encode($event));
    }

    public function get($params): array
    {
        $events = $this->redisClient->lrange($this->eventsKey, 0, -1);
        $matchingEvents = [];

        foreach ($events as $eventJson) {
            $event = json_decode($eventJson, true);
            if ($this->conditionsMatch($event['conditions'], $params)) {
                $matchingEvents[] = $event;
            }
        }

        if (empty($matchingEvents)) {
            return [];
        }

        usort($matchingEvents, function ($a, $b) {
            return $b['priority'] - $a['priority'];
        });

        return $matchingEvents[0]['event'];
    }

    /**
     * @throws \RedisException
     */
    public function clear(): void
    {
        $this->redisClient->del($this->eventsKey);
    }

    private function conditionsMatch($eventConditions, $userParams): bool
    {
        foreach ($eventConditions as $param => $value) {
            if (!isset($userParams[$param]) || $userParams[$param] != $value) {
                return false;
            }
        }

        return true;
    }
}