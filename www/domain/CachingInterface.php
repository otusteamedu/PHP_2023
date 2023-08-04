<?php

namespace src\domain;

interface CachingInterface
{
    public function get(string $key);
    public function set(string $key, $value, int $sec): bool;
}
