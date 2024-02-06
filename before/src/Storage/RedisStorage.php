<?php

declare(strict_types=1);

namespace App\Storage;

use Redis;
use RedisException;
use RuntimeException;

class RedisStorage implements StorageInterface
{
    private Redis $storage;

    public function __construct()
    {
        if (!$config = parse_ini_file(dirname(__DIR__) . '/Config/config.ini')) {
            throw new RuntimeException('Не найден файл конфига');
        }

        if (!isset($config['host']) || !isset($config['port'])) {
            throw new RuntimeException('Не найдены переменные конфигурации');
        }

        $this->storage = new Redis();

        $host = $config['host'];
        $port = (int)$config['port'];

        try {
            $this->storage->connect($host, $port);
        } catch (RedisException $e) {
            throw new RuntimeException($e->getMessage());
        }

        try {
            if (!$this->storage->ping()) {
                throw new RuntimeException('Хранилище недоступно');
            }
        } catch (RedisException $e) {
            throw new RuntimeException($e->getMessage());
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
