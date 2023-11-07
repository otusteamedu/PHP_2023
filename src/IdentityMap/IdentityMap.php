<?php

declare(strict_types=1);

namespace App\IdentityMap;

class IdentityMap
{
    private array $objects = [];

    public function getObjects(): array
    {
        return $this->objects;
    }

    public function setObjects(array $objects): void
    {
        $this->objects = $objects;
    }

    public function addObject(object $object): void
    {
        $key = get_class($object) . $object->getId();
        $this->objects[$key] = $object;
    }

    public function getByKey(string $key): ?object
    {
        return $this->objects[$key] ?? null;
    }

    public function deleteByKey(string $key): void
    {
        unset($this->objects[$key]);
    }

    public function resetObjects(): void
    {
        unset($this->objects);
    }
}
