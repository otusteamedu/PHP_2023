<?php

namespace YakovGulyuta\Hw15\Domain\Repository;

use YakovGulyuta\Hw15\Domain\Contract\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{

    public function findAll(): array
    {
        // находим все записи в нашем хранилище
    }

    public function findOne(int $id): ?object
    {
        // находим одну запись в нашем хранилище
    }

    public function save(object $entity): void
    {
        // сохраняем сущности в нашем хранилище
    }

}