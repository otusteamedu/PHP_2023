<?php

declare(strict_types=1);

namespace src\Infrastructure\Repository;

use src\Domain\Entity\Food\FoodInterface;
use src\Domain\Repository\FoodRepositoryInterface;

class FoodRepository implements FoodRepositoryInterface
{
    public function getById(int $id): FoodInterface
    {
        // TODO: Implement getById() method.
    }

    public function update(FoodInterface $food): void
    {
        // TODO: Implement update() method.
    }

    public function create(FoodInterface $food): FoodInterface
    {
        // TODO: Implement create() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}
