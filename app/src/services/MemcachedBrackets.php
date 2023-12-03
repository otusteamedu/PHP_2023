<?php

namespace Myklon\Hw4\Services;

class MemcachedBrackets
{
    private $memcached;

    public function __construct()
    {
        $this->memcached = new \Memcached();
        $this->memcached->addServer('memcached', 11211);
    }

    public function cacheBracketString(string $input, string $cachedValue)
    {
        $this->memcached->set($input, $cachedValue);
    }

    public function getCachedBracketString(string $input): ?string
    {
        return $this->memcached->get($input);
    }
}