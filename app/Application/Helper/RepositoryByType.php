<?php

namespace App\Application\Helper;

use App\Infrastructure\MongoDB\Repository\MongoNativeClientRepository;
use App\Infrastructure\Redis\Repository\PRedisClientRepository;
use App\Infrastructure\Redis\Repository\RedisNativeClientRepository;
use App\Infrastructure\RepositoryInterface;

class RepositoryByType
{
    public function get($config): RepositoryInterface
    {
        $type = $config->get('USE_REPOSITORY');
        $matchRepository = match (true) {
            $this->isRedis($type) => RedisNativeClientRepository::class,
            $this->isMongo($type) => MongoNativeClientRepository::class,
            $this->isPRedis($type) => PRedisClientRepository::class,
            default => throw new \Exception("Error: type `{$type}` repository!")
        };

        return new $matchRepository($config);
    }

    private function isRedis(string $type): bool
    {
        return in_array($type, ['redis',]);
    }

    private function isPRedis(string $type): bool
    {
        return in_array($type, ['predis',]);
    }

    private function isMongo(string $type): bool
    {
        return in_array($type, ['mongo',]);
    }
}
