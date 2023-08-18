<?php

declare(strict_types=1);

namespace Neunet\App;

use Neunet\App\StorageService\Service\RedisService;
use Neunet\App\StorageService\StorageService;

class App
{
    public function run(): void
    {
        $storageService = new StorageService();
        echo $storageService->handle(new RedisService());
    }
}
