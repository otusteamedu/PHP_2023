<?php

namespace src\domain;

use Memcache;

class MemcacheCachingCommon implements CachingCommonInterface
{
    private Memcache $memcache;

    public function connect(string $host, int $port): bool
    {
        $this->memcache = new Memcache();
        return $this->memcache->connect($host, $port);
    }

    public function disconnect(): bool
    {
        return $this->memcache->close();
    }

    public function get(string $key)
    {
        return $this->memcache->get($key);
    }

    public function set(string $key, $value, int $sec): bool
    {
        return $this->memcache->set($key, $value, false, $sec);
    }
}
