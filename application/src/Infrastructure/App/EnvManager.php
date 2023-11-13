<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\App;

class EnvManager
{
    public const ENV_STORAGE = 'STORAGE';
    public const ENV_REDIS_HOST = 'REDIS_HOST';
    public const ENV_MONGO_HOST = 'MONGO_HOST';
    public const ENV_MONGO_DATABASE = 'MONGO_DATABASE';
    public const ENV_MONGO_USER = 'MONGO_ROOT_USERNAME';
    public const ENV_MONGO_PASSWORD = 'MONGO_ROOT_PASSWORD';

    public function getStorage(): ?string
    {
        return $_ENV[self::ENV_STORAGE] ?? null;
    }

    public function getRedisHost(): ?string
    {
        return $_ENV[self::ENV_REDIS_HOST] ?? null;
    }

    public function getMongoHost(): ?string
    {
        return $_ENV[self::ENV_MONGO_HOST] ?? null;
    }

    public function getMongoDatabase(): ?string
    {
        return $_ENV[self::ENV_MONGO_DATABASE] ?? null;
    }

    public function getMongoUser(): ?string
    {
        return $_ENV[self::ENV_MONGO_USER] ?? null;
    }

    public function getMongoPassword(): ?string
    {
        return $_ENV[self::ENV_MONGO_PASSWORD] ?? null;
    }
}
