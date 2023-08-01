<?php

declare(strict_types=1);

namespace Art\Code\Storage;

use Art\Code\ConfigService\ConfigDefinition;
use InvalidArgumentException;

final class StorageDefinition
{
    public function __construct(private ConfigDefinition $config)
    {;
    }

    public function getStorage(string $typeStorage): StorageInterface
    {
        $result = match ($typeStorage) {
            'redis' => new RedisStorage($this->config->getOptions()),
            'memcached' => '...',
            default => throw new InvalidArgumentException("Storage type not defined!"),
        };

        return $result;
    }
}
