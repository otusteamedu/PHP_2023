<?php

namespace src\domain;

use Memcache;
use Redis;

class FabricCaching
{
    public static function build(string $name): CachingCommonInterface
    {
        $cachings = [
            Redis::class => RedisCachingCommon::class,
            Memcache::class => MemcacheCachingCommon::class,
        ];

        return new $cachings[$name]();
    }
}
