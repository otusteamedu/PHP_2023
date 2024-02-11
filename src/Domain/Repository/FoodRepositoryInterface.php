<?php

declare(strict_types=1);

namespace src\Domain\Repository;

use src\Domain\Entity\Food\FoodAbstract;

interface FoodRepositoryInterface
{
    public function getById(int $id): FoodAbstract;

    public function update(FoodAbstract $food): void;

    public function create(FoodAbstract $food): FoodAbstract;

    public function delete(int $id): void;
}
