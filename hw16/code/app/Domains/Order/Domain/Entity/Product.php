<?php

namespace App\Domains\Order\Domain\Entity;

use App\Domains\Order\Domain\ValueObjects\Description;
use App\Domains\Order\Domain\ValueObjects\Name;

class Product
{
    private array $ingredients = [];

    public function __construct(
        private Name $name,
        private Description $description,
    )
    {
    }

    public static function createFromArray(array $data): Product
    {
        return new Product(
            new Name($data['name']),
            new Description($data['description']),
        );
    }

    public function addIngredient(Ingredient $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }


    public function getName(): Name
    {
        return $this->name;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }


}
