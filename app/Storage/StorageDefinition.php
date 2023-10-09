<?php

declare(strict_types=1);

namespace App\Storage;

use App\ConfigService\ConfigDefinition;
use InvalidArgumentException;

final class StorageDefinition
{
    public function __construct(private ConfigDefinition $config)
    {
    }

    public function getStorage(string $typeStorage): StorageInterface
    {
        return match ($typeStorage) {
            'redis' => new RedisStorage($this->config->getOptions()),
            'memcached' => '...',
            default => throw new InvalidArgumentException("Storage type not defined!"),
        };
    }
}
