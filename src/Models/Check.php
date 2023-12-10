<?php
declare(strict_types=1);


namespace Ekovalev\Otus\Models;

use RedisException;

class Check
{
    /**
     * @throws RedisException
     */
    public static function redisCheck(): false|array|\Redis
    {
        $redis = new \Redis();
        $redis->connect('redis', 6379);
        return $redis->info();
    }

    public static function memcacheCheck(): false|string
    {
        $memcache = new \Memcache();
        $memcache->connect('memcached', 11211);
        return $memcache->getVersion();
    }

    public static function mysqlCheck(): string
    {
        $mysqli = new \Mysqli(
            'mysql',
            'dev',
            '123456',
            'loc',
            3306
        );
        return $mysqli->server_info;
    }

}
