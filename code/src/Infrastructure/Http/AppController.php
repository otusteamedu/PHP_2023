<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Http;

use Art\Code\Application\Dto\StorageDefinitionRequest;
use Art\Code\Application\UseCase\ConfigDefinitionUseCase;
use Art\Code\Application\UseCase\PostUseCase;
use Art\Code\Application\UseCase\StorageDefinitionUseCase;
use JsonException;

final class AppController
{
    private string $config_file = __DIR__ . '/config.ini';
    private StorageDefinitionUseCase $storageDefinition;

    /**
     * @param StorageDefinitionRequest $typeStorage
     */
    public function __construct(public StorageDefinitionRequest $typeStorage)
    {
        $config = new ConfigDefinitionUseCase($this->config_file);
        $this->storageDefinition = new StorageDefinitionUseCase($config);
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function run(): string
    {
        $storage = $this->storageDefinition->getStorage($this->typeStorage);
        $processor = new PostUseCase($storage);

        return $processor->process()->send();
    }
}

