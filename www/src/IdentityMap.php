<?php

declare(strict_types=1);

namespace Chernomordov\App;

class IdentityMap
{
    private array $objects = [];

    /**
     * @return array<object>
     */
    public function getAll(): array
    {
        return $this->objects;
    }

    public function get(string $classIdentifier, int $id): ?object
    {
        return $this->objects[$classIdentifier][$id] ?? null;
    }

    public function set($object): void
    {
        $this->objects[$object::class][$object->getId()] = $object;
    }

    public function remove($object): void
    {
        if (isset($this->objects[$object::class][$object->getId()])) {
            unset($this->objects[$object::class][$object->getId()]);
        }
    }

    public function reset(): void
    {
        unset($this->objects);
    }
}
