<?php

declare(strict_types=1);

namespace Twent\Hw13\Database;

use ArrayObject;

final class IdentityMap
{
    public function __construct(
        private array $map = [],
    ) {
    }

    public function set(string|int $id, $object): void
    {
        $this->map[$id] = $object;
    }

    public function get(string|int $id)
    {
        if (! $this->hasId($id)) {
            throw new \Exception('Объект не найден');
        }

        return $this->map[$id];
    }

    public function hasId(string|int $id): bool
    {
        return key_exists($id, $this->map);
    }

    public function hasObject(mixed $object): int|string|false
    {
        return array_search($object, $this->map);
    }

    public function forgot(string|int $id): void
    {
        if (! $this->hasId($id)) {
            throw new \Exception('Объект не найден');
        }

        unset($this->map[$id]);
    }

    public function forgotAll(): void
    {
        unset($this->map);
    }
}
