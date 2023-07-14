<?php

declare(strict_types=1);

namespace Root\App;

interface StorageInterface
{
    public function add(array $param): void;
    public function get(array $param): ?array;
    public function clear() : void;
}
