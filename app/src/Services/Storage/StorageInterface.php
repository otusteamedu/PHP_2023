<?php

declare(strict_types=1);

namespace Yevgen87\App\Services\Storage;

interface StorageInterface
{
    public function store(int $priority, array $conditions, string $event);

    public function deleteAll();

    public function delete(string $key);

    public function getRelevant(array $conditions);
}
