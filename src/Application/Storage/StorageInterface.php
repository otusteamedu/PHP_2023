<?php

declare(strict_types=1);

namespace App\Application\Storage;

interface StorageInterface
{
    public function set(int $priority, array $conditions, string $event): void;

    public function get(array $params): array;

    public function clear(): void;
}
