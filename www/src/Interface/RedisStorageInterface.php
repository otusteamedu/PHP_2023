<?php

declare(strict_types=1);

namespace Chernomordov\App\Interface;

interface RedisStorageInterface
{
    /**
     * @param int $priority
     * @param string $event
     * @param array $conditions
     * @return void
     */
    public function add(int $priority, array $conditions, string $event): void;

    /**
     * @param array $params
     * @return array
     */
    public function get(array $params): array;

    /**
     * @return void
     */
    public function clear(): void;

}