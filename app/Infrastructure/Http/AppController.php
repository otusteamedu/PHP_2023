<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\PostProcessor;
use App\Application\UseCase\StorageDefinitionUseCase;
use App\ConfigService\ConfigDefinition;

class AppController
{
    private string $config_file = __DIR__.'/config.ini';
    private StorageDefinitionUseCase $storageDefinition;

    public function __construct(private string $typeStorage)
    {
        $config                  = new ConfigDefinition($this->config_file);
        $this->storageDefinition = new StorageDefinitionUseCase($config);
    }

    public function run(): string
    {
        $storage   = $this->storageDefinition->getStorage($this->typeStorage);
        $processor = new PostProcessor($storage);

        return $processor->process()->send();
    }
}