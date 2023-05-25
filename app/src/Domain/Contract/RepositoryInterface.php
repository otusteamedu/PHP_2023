<?php

namespace YakovGulyuta\Hw15\Domain\Contract;

interface RepositoryInterface
{
    public function findAll(): array;

    public function findOne(int $id): ?object;

    public function save(object $entity): void;
}
