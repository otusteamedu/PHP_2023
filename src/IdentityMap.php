<?php

namespace App;

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

    public function get(string $classIdentifier, int $id): ?IdentityInterface
    {
        return $this->objects[$classIdentifier][$id] ?? null;
    }

    public function set(IdentityInterface $object): void
    {
        $this->objects[$object::class][$object->getId()] = $object;
    }

    public function remove(IdentityInterface $object): void
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
