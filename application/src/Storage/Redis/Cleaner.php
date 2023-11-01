<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Redis;

class Cleaner
{
    private \Redis $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws \RedisException|RedisStorageException
     */
    public function clear(): void
    {
        $this->deleteKeys($this->getEventKeys());
        $this->deleteKeys($this->getConditionKeys());
    }

    /**
     * @throws \RedisException
     * @throws RedisStorageException
     */
    private function getEventKeys(): array
    {
        $keys = $this->redis->keys('event:*');

        if ($keys === false) {
            throw RedisStorageException::cannotGetKeysOfEvents();
        }

        return (array) $keys;
    }

    /**
     * @throws \RedisException
     * @throws RedisStorageException
     */
    private function getConditionKeys(): array
    {
        $keys = $this->redis->keys('conditions:*');

        if ($keys === false) {
            throw RedisStorageException::cannotGetKeysOfConditions();
        }

        return (array) $keys;
    }

    /**
     * @throws \RedisException
     */
    private function deleteKeys(array $keys): void
    {
        if (empty($keys)) {
            return;
        }

        $this->redis->del($keys);
    }
}