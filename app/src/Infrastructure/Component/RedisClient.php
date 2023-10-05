<?php

declare(strict_types=1);

namespace App\Infrastructure\Component;

use Redis;

final class RedisClient
{
    public function __construct(
        private readonly Redis $redis,
    ) {
    }

    /**
     * @return Redis
     */
    public function getRedis(): Redis
    {
        return $this->redis;
    }
}
