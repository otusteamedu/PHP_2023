<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage;

use Gesparo\HW\Storage\ValueObject\StoreElement;

interface StoreInterface
{
    /**
     * @return StoreElement[]
     */
    public function getAll(): array;

    public function save(string $phone, string $message): void;

    public function count(): int;

    public function clear(): void;
}
