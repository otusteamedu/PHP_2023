<?php

namespace App\Application\Adapter;

use App\Infrastructure\GetterInterface;
use NdybnovHw03\CnfRead\Storage;

class ConfigToGetterAdapter implements GetterInterface
{
    private Storage $configStorage;

    public function __construct(Storage $configStorage)
    {
        $this->configStorage = $configStorage;
    }

    public function get(string $key): string
    {
        return $this->configStorage->get($key);
    }
}
