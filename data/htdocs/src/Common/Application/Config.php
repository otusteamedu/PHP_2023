<?php

namespace Common\Application;

use Tools\Arr;

class Config implements ConfigInterface
{
    public function __construct(
        private array $config
    )
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->config, $key) ?? $default;
    }
}