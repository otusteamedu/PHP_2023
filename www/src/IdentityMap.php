<?php

declare(strict_types=1);

namespace Khalikovdn\Hw13;

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

    /**
     * @param string $classIdentifier
     * @param int $id
     * @return object|mixed|null
     */
    public function get(string $classIdentifier, int $id): ?object
    {
        return $this->objects[$classIdentifier][$id] ?? null;
    }

    /**
     * @param $object
     * @return void
     */
    public function set($object): void
    {
        $this->objects[$object::class][$object->getId()] = $object;
    }

    /**
     * @param $object
     * @return void
     */
    public function update($object): void
    {
        $this->set($object);
    }

    /**
     * @param $object
     * @return void
     */
    public function remove($object): void
    {
        if (isset($this->objects[$object::class][$object->getId()])) {
            unset($this->objects[$object::class][$object->getId()]);
        }
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        unset($this->objects);
    }
}
