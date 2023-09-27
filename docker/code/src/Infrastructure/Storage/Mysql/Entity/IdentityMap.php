<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Entity;

class IdentityMap
{
    private array $objects = [];

    /**
     * @param int $id
     * @return object|null
     */
    public function get(string $id): ?object
    {
        return $this->objects[$id] ?? null;
    }

    /**
     * @param int $id
     * @param object $object
     * @return void
     */
    public function set(string $id, object $object): void
    {
        $this->objects[$id] = $object;
    }

    /**
     * @param int $id
     * @param     $object
     * @return void
     */
    public function remove(string $id): void
    {
        if (isset($this->objects[$id])) {
            unset($this->objects[$id]);
        }
    }

    /**
     * @return void
     */
    public function removeAll(): void
    {
        unset($this->objects);
    }
}
