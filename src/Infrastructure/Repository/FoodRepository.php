<?php

declare(strict_types=1);

namespace src\Infrastructure\Repository;

use src\Domain\Entity\Food\FoodAbstract;
use src\Domain\Repository\FoodRepositoryInterface;

class FoodRepository implements FoodRepositoryInterface
{

    public function getById(int $id): FoodAbstract
    {
        // TODO: Implement getById() method.
    }

    public function update(FoodAbstract $food): void
    {
        // TODO: Implement update() method.
    }

    public function create(FoodAbstract $food): FoodAbstract
    {
        // TODO: Implement create() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}
