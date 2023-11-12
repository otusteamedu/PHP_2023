<?php

declare(strict_types=1);

namespace User\Php2023;

class DIContainer
{
    private $services = [];

    public function set($key, $value): void
    {
        $this->services[$key] = $value;
    }

    public function get($key)
    {
        return $this->services[$key]($this);
    }
}