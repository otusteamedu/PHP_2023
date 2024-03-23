<?php

declare(strict_types=1);

namespace AYamaliev\hw13\IdentityMap;

class IdentityMap
{
    private array $storage = [];

    public function getAll(): array
    {
        return $this->storage;
    }

    public function get(string $className, int $id): ?IdentityMapInterface
    {
        return $this->storage[$className][$id] ?? null;
    }

    public function set(IdentityMapInterface $object): ?IdentityMapInterface
    {
        $this->storage[$object::class][$object->getId()] = $object;
        return $this->storage[$object::class][$object->getId()];
    }

    public function remove(IdentityMapInterface $object): void
    {
        if (isset($this->storage[$object::class][$object->getId()])) {
            unset($this->storage[$object::class][$object->getId()]);
        }
    }
}
