<?php

namespace App\Domains\Order\Domain\Entity\Product;

use App\Domains\Order\Domain\Strategies\Cock\CockStrategyInterface;
use App\Domains\Order\Domain\ValueObjects\Status;

abstract class AbstractProduct
{
    protected array $ingredients = [];
    protected Status $status;

    public function __construct(
        protected CockStrategyInterface $cockStrategy
    )
    {
    }

    public function addAdditionalIngredient(string $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    public function addDefaultIngredients(array $defaultIngredients): void
    {
        $this->ingredients = array_merge($this->ingredients, $defaultIngredients);
    }

    public function cock(): void
    {
         $this->cockStrategy->run();
         $this->status = new Status('complete');
    }
}
