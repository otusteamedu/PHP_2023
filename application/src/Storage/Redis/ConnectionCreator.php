<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Redis;

class ConnectionCreator
{
    private string $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    /**
     * @throws \RedisException
     */
    public function create(): \Redis
    {
        $redis = new \Redis();
        $redis->connect($this->host);

        return $redis;
    }
}
