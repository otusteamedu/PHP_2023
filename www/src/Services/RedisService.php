<?php

declare(strict_types=1);

namespace Yalanskiy\HomeworkRedis\Services;

use Redis;
use RedisException;
use Yalanskiy\HomeworkRedis\StorageInterface;

/**
 * RedisService Class
 */
class RedisService implements StorageInterface
{
    private Redis $redis;
    private const SET_NAME = 'events';

    /**
     * @throws RedisException
     */
    public function __construct(string $host, int $port)
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
        $this->redis->select(0);
    }

    /**
     * Clear DB
     * @throws RedisException
     */
    public function clear(): void
    {
        $this->redis->flushDB();
    }

    /**
     * Add item to DB
     * @throws RedisException
     */
    public function add(string $event, int $score, array $params): void
    {
        $this->redis->zAdd(self::SET_NAME, $score, $event);
        foreach ($params as $paramName => $paramValue) {
            $this->redis->hSet($event, $paramName, $paramValue);
        }
    }

    /**
     * @throws RedisException
     */
    public function search(array $params, int $limit = 0): array
    {
        $length = $this->redis->zCard(self::SET_NAME);
        $events = $this->redis->zRevRange(self::SET_NAME, 0, $length - 1);

        $found = [];
        foreach ($events as $event) {
            $allParamsFound = true;
            foreach ($params as $paramName => $paramValue) {
                if (
                    !$this->redis->hExists($event, $paramName)
                    || $this->redis->hGet($event, $paramName) != $paramValue
                ) {
                    $allParamsFound = false;
                }
            }
            if ($allParamsFound) {
                $found[] = [
                    'event' => $event,
                    'score' => $this->redis->zScore(self::SET_NAME, $event),
                    'params' => $params
                ];

                if ($limit !== 0 && count($found) >= $limit) {
                    break;
                }
            }
        }

        return $found;
    }
}
