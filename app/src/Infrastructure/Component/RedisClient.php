<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Component;

use Redis;

final class RedisClient
{
    public function __construct(
        private readonly Redis $redis,
        string $host,
        int $port,
    ) {
        $this->redis->connect($host, $port);
    }

    /**
     * @return Redis
     */
    public function getRedis(): Redis
    {
        return $this->redis;
    }
}
