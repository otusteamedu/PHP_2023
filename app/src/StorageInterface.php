<?php

declare(strict_types=1);

namespace Root\App;

interface StorageInterface
{
    public function createIndex(string $mapping): void;
    public function bulk(string $data): void;
    public function exists(): bool;

    /**
     * @param array $params
     * @return TableRowDto[]
     */
    public function find(array $params): array;
}
