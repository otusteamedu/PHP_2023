<?php

declare(strict_types=1);

namespace App;

use App\ConfigService\ConfigDefinition;
use App\Service\PostProcessor;
use App\Storage\StorageDefinition;

final class App
{
    private string $config_file = __DIR__ . '/config.ini';
    private StorageDefinition $storageDefinition;

    public function __construct(private string $typeStorage)
    {
        $config = new ConfigDefinition($this->config_file);
        $this->storageDefinition = new StorageDefinition($config);
    }

    public function run()
    {
        $storage = $this->storageDefinition->getStorage($this->typeStorage);
        $processor = new PostProcessor($storage);

        return $processor->process()->send();
    }
}
