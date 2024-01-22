<?php

namespace Shabanov\Otusphp\Db;


use Exception;

class RedisClient implements DbManager
{
    private static ?self $instance = null;
    private \Redis $client;

    private function __construct()
    {
        $this->client = (new \Redis([
            'host' => $_ENV['REDIS_HOST'],
            'port' => (int)$_ENV['REDIS_PORT'],
        ]));
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @throws Exception
     */
    public function getClient(): \Redis
    {
        try {
            return $this->client;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
