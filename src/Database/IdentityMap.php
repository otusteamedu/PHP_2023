<?php

declare(strict_types=1);

namespace Otus\App\Database;

final class IdentityMap
{
    /**
     * @var array<class-string, array<int|string, object>>
     */
    private array $objects = [];

    /**
     * @template T of object
     * @param class-string<T> $fqcn
     *
     * @return T
     */
    public function get(string $fqcn, int $id): ?object
    {
        return $this->objects[$fqcn][$id] ?? null;
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

    public function removeAll(): void
    {
        unset($this->objects);
    }
}
