<?php

declare(strict_types=1);

namespace Gesparo\HW;

class EnvManager
{
    public const ENV_STORAGE = 'STORAGE';
    public const ENV_REDIS_HOST = 'REDIS_HOST';

    public function getStorage(): ?string
    {
        return $_ENV[self::ENV_STORAGE] ?? null;
    }

    public function getRedisHost(): ?string
    {
        return $_ENV[self::ENV_REDIS_HOST] ?? null;
    }
}