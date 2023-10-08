<?php

/**
 * Класс хранилища Redis
 */

namespace App\Storage;

use Redis;
use RedisException;

class RedisStorage implements Storage
{
    private Redis $redis;

    private string $key;

    /**
     * @throws RedisException
     */
    public function __construct(string $key, string $host)
    {
        $this->redis = new Redis();
        $this->redis->connect($host);
        $this->key = $key;
    }

    /**
     * @throws RedisException
     */
    public function add(int $priority, array $conditions, mixed $event): void
    {
        $this->redis->zAdd($this->key, $priority, json_encode(['conditions' => $conditions, 'event' => $event]));
    }

    /**
     * @throws RedisException
     */
    public function clear(): void
    {
        $this->redis->del($this->key);
    }

    /**
     * @throws RedisException
     */
    public function get(array $params): mixed
    {
        $events = $this->redis->zRevRange($this->key, 0, -1);

        foreach ($events as $event) {
            $eventData = json_decode($event, true);
            $eventFound = true;

            foreach ($eventData['conditions'] as $k => $v) {
                if (!isset($params[$k]) || $params[$k] != $v) {
                    $eventFound = false;
                    break;
                }
            }

            if ($eventFound) {
                return $eventData['event'];
            }
        }

        return null;
    }
}
