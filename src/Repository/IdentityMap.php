<?php
declare(strict_types=1);

namespace WorkingCode\Hw13\Repository;

use WorkingCode\Hw13\Entity\EntityInterface;

class IdentityMap
{
    private array $elements = [];

    public function add(EntityInterface $entity): void
    {
        $this->elements[$entity::class][] = $entity;
    }

    public function get(string $class, int $id): ?EntityInterface
    {
        if (isset($this->elements[$class][$id])) {
            return $this->elements[$class][$id];
        }

        return null;
    }

    public function getAll(string $class): array
    {
        if (isset($this->elements[$class])) {
            return $this->elements[$class];
        }

        return [];
    }

    public function remove(EntityInterface $entity): void
    {
        if (isset($this->elements[$entity::class][$entity->getId()])) {
            unset($this->elements[$entity::class][$entity->getId()]);
        }
    }

    public function getIds(string $class): array
    {
        $ids = [];

        if (isset($this->elements[$class])) {
            $ids = array_map(static fn (EntityInterface $entity) => $entity->getId(), $this->elements[$class]);
        }

        return $ids;
    }
}
