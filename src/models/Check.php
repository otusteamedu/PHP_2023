<?php
declare(strict_types=1);

class Check
{
    public static function redisCheck() {
        $redis = new Redis();
        $redis->connect('redis', 6379);
        return $redis->info();
    }

    public static function memcacheCheck() {
        $memcache = new Memcache();
        $memcache->connect('memcached', 11211);
        return $memcache->getVersion();
    }

    public static function mysqlCheck() {
        $mysqli = new Mysqli(
            'mysql',
            'dev',
            '123456',
            'loc',
            3306
        );
        return $mysqli->server_info;
    }

}
