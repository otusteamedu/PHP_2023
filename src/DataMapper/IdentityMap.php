<?php

declare(strict_types=1);

namespace App\DataMapper;

final class IdentityMap
{
    private array $entities = [];

    public function add(EntityInterface $entity): void
    {
        if ($entity->getId() === null) {
            return;
        }

        $this->entities[$entity::class][$entity->getId()] = $entity;
    }

    public function get(string $class, int $id): ?EntityInterface
    {
        return $this->entities[$class][$id] ?? null;
    }

    public function remove(EntityInterface $entity): void
    {
        if (isset($this->entities[$entity::class][$entity->getId()])) {
            unset($this->entities[$entity::class][$entity->getId()]);
        }
    }

    public function clear(): void
    {
        $this->entities = [];
    }
}
