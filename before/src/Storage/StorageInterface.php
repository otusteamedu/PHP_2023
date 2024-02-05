<?php

declare(strict_types=1);

namespace App\Storage;

use Exception;

interface StorageInterface
{
    /**
     * @throws Exception
     */
    public function add(string $key, int $priority, string $value);

    /**
     * @throws Exception
     */
    public function read(string $key): array|null;

    /**
     * @throws Exception
     */
    public function deleteAll();
}
