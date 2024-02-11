<?php

declare(strict_types=1);

namespace src\Domain\Repository;

use src\Domain\Entity\Food\FoodInterface;

interface FoodRepositoryInterface
{
    public function getById(int $id): FoodInterface;

    public function update(FoodInterface $food): void;

    public function create(FoodInterface $food): FoodInterface;

    public function delete(int $id): void;
}
