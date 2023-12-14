<?php

namespace App\Storage;

interface StorageInterface
{
    public function add(int $priority, string $event, array $conditions): void;

    public function get(array $params): array;

    public function clear(): void;
}
