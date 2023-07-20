<?php

declare(strict_types=1);

namespace Imitronov\Hw13\Component\IdentityMap;

final class IdentityMap
{
    private array $objects = [];

    public function set(int $id, $object): void
    {
        $this->objects[$id] = $object;
    }

    public function has(int $id): bool
    {
        return array_key_exists($id, $this->objects);
    }

    public function get(int $id): mixed
    {
        if (!$this->has($id)) {
            return null;
        }

        return $this->objects[$id];
    }

    public function remove(int $id): void
    {
        if ($this->has($id)) {
            unset($this->objects[$id]);
        }
    }
}
