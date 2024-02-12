<?php
declare(strict_types=1);

namespace App\Builder;

interface FoodInterface
{
    public function getDescription(): string;

    public function getPrice(): float;

    public function getName(): string;

    public function getIngredients(): array;

    public function toCook(): string;
}
