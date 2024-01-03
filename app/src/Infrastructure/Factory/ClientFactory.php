<?php

namespace App\Infrastructure\Factory;

use Ehann\RedisRaw\AbstractRedisRawClient;
use Ehann\RedisRaw\RedisClientAdapter;
use Exception;

class ClientFactory
{
    private const REDIS_HOSTNAME = 'redis';

    /**
     * @throws Exception
     */
    public static function create(): AbstractRedisRawClient
    {
        try {
            $client = new RedisClientAdapter();
            $client->connect(self::REDIS_HOSTNAME);
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $client;
    }
}
