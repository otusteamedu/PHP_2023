<?php

declare(strict_types=1);

namespace App\Storage;

use App\Config\ConfigInterface;
use Redis;
use RedisException;
use RuntimeException;

class RedisStorage implements StorageInterface
{
    private Redis $storage;

    public function __construct(ConfigInterface $config)
    {
        $this->storage = new Redis();

        try {
            $this->storage->connect($config->getHost(), $config->getPort());
        } catch (RedisException) {
            throw new RuntimeException('Ошибка подключения к Redis');
        }
    }

    public function add(string $key, int $priority, string $value): void
    {
        $this->storage->zAdd($key, $priority, $value);
    }

    public function read(string $key): array|null
    {
        return $this->storage->zRevRange($key, 0, -1);
    }

    public function deleteAll(): void
    {
        $this->storage->flushDB();
    }
}
