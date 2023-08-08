<?php

declare(strict_types=1);

namespace DEsaulenko\Hw12\Storage;

use DEsaulenko\Hw12\Constants;
use Exception;
use Redis;

class RedisStorage implements StorageInterface
{
    public const NO_CONNECT = 'No connection to redis';
    protected Redis $storage;

    public function __construct()
    {
        try {
            $this->storage = new Redis();
            $host = getenv(Constants::REDIS_HOST);
            $port = getenv(Constants::REDIS_PORT) ? (int)getenv(Constants::REDIS_PORT) : Constants::REDIS_PORT_DEFAULT;
            $this->storage->connect($host, $port);
            if (!$this->storage->ping()) {
                throw new Exception(self::NO_CONNECT);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create(string $key, string $value, int $priority): bool
    {
        return (bool)$this->storage->zAdd($key, $priority, $value);
    }

    public function read(string $key): array
    {
        $data = $this->storage->zRevRangeByScore(
            $key,
            '+inf',
            '-inf',
            [
                'WITHSCORES' => true,
                'LIMIT' => [
                    0,
                    1
                ]
            ]
        );
        if (!is_array($data)) {
            return [];
        }

        $result = [];
        foreach ($data as $key => $value) {
            $result[$value] = $key;
        }
        return $result;
    }

    public function deleteAll(): void
    {
        $this->storage->flushAll();
    }
}
