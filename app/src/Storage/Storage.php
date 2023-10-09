<?php

/**
 * Интерфейс, который должны реализовать все хранилища,
 * чтобы было легко поменять тип хранилища в клиентском коде.
 */

namespace App\Storage;

use Exception;

interface Storage
{
    /** @throws Exception */
    public function add(int $priority, array $conditions, string $event): void;

    /** @throws Exception */
    public function clear(): void;

    /** @throws Exception */
    public function get(array $params): array;
}
