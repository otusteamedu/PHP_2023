<?php

declare(strict_types=1);

namespace Vp\App\Storage\Connections;

use Exception;
use Redis;

class ConnectionRedis
{
    private static self|null $_instance = null;
    private static Redis $_connection;

    /**
     * @throws \RedisException
     */
    private function __construct()
    {
        $redis = new Redis();
        $redis->connect('redis');

        static::$_connection = $redis;
    }

    public static function getInstance(): self
    {
        if (!static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    public function getConnection(): Redis
    {
        return static::$_connection;
    }

    private function __clone()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
