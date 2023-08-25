<?php

namespace IilyukDmitryi\App\Domain\CreatorFood;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\Food\Food;

class CreatorBurger implements CreatorFoodStrategyInterface
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
            ->setNameFood("Бургер")
            ->setPrice(5)
            ->setIngredients($this->ingredients);

        return $food;
    }

    protected function cook(): void
    {
        $this->bakeBun();
        $this->addSauce();
        $this->addCheese();
        $this->fryCutlets();
        $this->addTomato();
    }

    protected function bakeBun(): void
    {
        $this->ingredients[] = 'булочка';
    }

    protected function addSauce(): void
    {
        $this->ingredients[] = 'соус';
    }

    protected function addCheese(): void
    {
        $this->ingredients[] = 'сыр';
    }

    protected function fryCutlets(): void
    {
        $this->ingredients[] = 'котлета';
    }

    protected function addTomato(): void
    {
        $this->ingredients[] = 'помидор';
    }
}
