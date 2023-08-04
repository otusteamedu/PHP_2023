<?php

namespace src\domain;

interface Caching_PSR_Interface
{
    public function get(string $key);
    public function set(string $key, $value, int $sec): bool;
}
