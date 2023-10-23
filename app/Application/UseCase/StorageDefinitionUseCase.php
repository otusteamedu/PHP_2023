<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Contracts\StorageInterface;
use App\ConfigService\ConfigDefinition;
use App\Domain\Models\RedisStorage;
use InvalidArgumentException;

final class StorageDefinitionUseCase
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
