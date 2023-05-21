<?php

namespace Sva\Common\Infrastructure;

use Exception;
use Redis;
use RedisException;
use Sva\Common\App\Env;

class RedisConnection
{
    use \Sva\Singleton;

    private Redis $connection;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    private function connect(): RedisConnection
    {
        $redis = new Redis();
        $redis->connect(Env::getInstance()->get('REDIS_HOST'), Env::getInstance()->get('REDIS_PORT'));

        if ($redis->ping()) {
            $this->connection = $redis;
        } else {
            throw new Exception('Redis connection error');
        }

        return $this;
    }

    /**
     * @return Redis
     */
    public function getConnection(): Redis
    {
        return $this->connection;
    }
}
