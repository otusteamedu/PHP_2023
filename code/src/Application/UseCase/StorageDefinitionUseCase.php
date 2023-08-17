<?php

declare(strict_types=1);

namespace Art\Code\Application\UseCase;

use Art\Code\Application\Contract\ConfigDefinitionInterface;
use Art\Code\Application\Contract\StorageDefinitionInterface;
use Art\Code\Application\Dto\StorageDefinitionRequest;
use Art\Code\Domain\Model\RedisStorage;
use Art\Code\Domain\Model\Storage;
use InvalidArgumentException;

final class StorageDefinitionUseCase implements StorageDefinitionInterface
{
    /**
     * @param ConfigDefinitionInterface $config
     */
    public function __construct(private readonly ConfigDefinitionInterface $config)
    {
    }

    /**
     * @param StorageDefinitionRequest $storage
     * @return Storage
     */
    public function getStorage(StorageDefinitionRequest $storage): Storage
    {
        return match ($storage->typeStorage) {
            'redis' => new RedisStorage($this->config->getOptions()),
//            'memcached' => '...',
            default => throw new InvalidArgumentException("Storage type not defined!"),
        };
    }
}
