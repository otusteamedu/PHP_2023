<?php

declare(strict_types=1);

namespace DShevchenko\Hw4;

class Cache {

    private \Memcached $cache;
    private bool $valueFound;

    public function __construct(string $host, int $port) {
        $this->cache = new \Memcached();
        $this->cache->addServer($host, $port);
        $this->valueFound = false; 
    }

    public function get(string $key) : mixed {
        $value = $this->cache->get($key);
        // Сохраняем факт наличия запрашиваемого ключа к кэше
        $this->valueFound = ($this->cache->getResultCode() === \Memcached::RES_SUCCESS);
        return $value;
    }

    public function set(string $key, mixed $value) : void {
        $this->cache->set($key, $value);
    }

    public function valueFound() : bool {
        return $this->valueFound;
    }

}