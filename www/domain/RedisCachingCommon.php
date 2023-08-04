<?php

namespace src\domain;

use Redis;
use RedisException;

class RedisCachingCommon implements CachingCommonInterface
{
    private Redis $redis;

    /**
     * @throws RedisException
     */
    public function connect(string $host, int $port): bool
    {
        $this->redis = new Redis();
        return $this->redis->connect($host, $port);
    }

    /**
     * @throws RedisException
     */
    public function disconnect(): bool
    {
        return $this->redis->close();
    }

    /**
     * @throws RedisException
     */
    public function get(string $key)
    {
        return $this->redis->get($key);
    }

    /**
     * @throws RedisException
     */
    public function set(string $key, $value, int $sec): bool
    {
        return $this->redis->set($key, $value, $sec);
    }
}
