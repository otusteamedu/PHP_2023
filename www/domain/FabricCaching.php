<?php

namespace src\domain;

use Memcache;
use Redis;

class FabricCaching
{
    public static function build(string $name): Caching_Interface
    {
        $cachings = [
            Redis::class => RedisCaching::class,
            Memcache::class => MemcacheCaching::class,
        ];

        return new $cachings[$name]();
    }
}
