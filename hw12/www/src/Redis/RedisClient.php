<?php

namespace Shabanov\Otusphp\Redis;

class RedisClient
{
    private static ?self $instance = null;
    private \Redis $rClient;
    private function __construct()
    {
        $this->rClient = (new \Redis([
            'host' => $_ENV['REDIS_HOST'],
            'port' => (int)$_ENV['REDIS_PORT'],
        ]));
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getClient(): \Redis
    {
        return $this->rClient;
    }
}
