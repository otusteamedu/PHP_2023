<?php

declare(strict_types=1);

namespace Root\App;

interface StorageInterface
{
    function createIndex(string $mapping): void;
    function bulk(string $data): void;
    function exists(): bool;

    /**
     * @param array $params
     * @return TableRowDto[]
     */
    function find(array $params): array;
}
