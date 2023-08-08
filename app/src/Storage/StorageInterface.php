<?php

declare(strict_types=1);

namespace DEsaulenko\Hw12\Storage;

interface StorageInterface
{
    public function create(string $key, string $value, int $priority);
    public function read(string $key);
    public function deleteAll();
}
