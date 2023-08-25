<?php

namespace IilyukDmitryi\App\Domain\CreatorFood;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\Food\Food;

class CreatorSandwich implements CreatorFoodStrategyInterface
{
    protected array $ingredients = [];

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function build(): Food
    {
        $this->cook();
        $food = (Di::getContainer()->get(Food::class))
            ->setNameFood("Сэндвич")
            ->setPrice(4)
            ->setIngredients($this->ingredients);

        return $food;
    }

    protected function cook(): void
    {
        $this->addBread();
        $this->addSauce();
        $this->addFish();
        $this->addOnion();
    }

    protected function addBread(): void
    {
        $this->ingredients[] = 'два кусочка хлеба';
    }

    protected function addSauce(): void
    {
        $this->ingredients[] = 'суос';
    }

    protected function addFish(): void
    {
        $this->ingredients[] = 'консервированный тунец';
    }

    protected function addOnion(): void
    {
        $this->ingredients[] = 'зеленый лук';
    }
}
