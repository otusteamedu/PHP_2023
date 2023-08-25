<?php

namespace IilyukDmitryi\App\Domain\CreatorFood;

use Exception;
use IilyukDmitryi\App\Domain\Food\Food;
use Throwable;

class CreatorHotDogProxy implements CreatorFoodStrategyInterface
{
    protected CreatorFoodStrategyInterface $creatorSandwich;

    public function __construct()
    {
        $this->creatorSandwich = new CreatorSandwich();
    }

    /**
     * @throws Exception
     */
    public function build(): Food
    {
        try {
            $food = $this->creatorSandwich->build();
            $food->setIngredients(['булка', 'сосиска', 'кетчуп']);
            $food->setNameFood('ХотДог');
        } catch (Throwable $th) {
            $message = $th->getMessage();
            $message = str_ireplace('Сэндвич', 'ХотДог', $message);
            throw new Exception($message . '123213');
        }
        return $food;
    }
}
