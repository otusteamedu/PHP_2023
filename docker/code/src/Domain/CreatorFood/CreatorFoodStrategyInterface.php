<?php

namespace IilyukDmitryi\App\Domain\CreatorFood;

use IilyukDmitryi\App\Domain\Food\FoodInterface;

interface CreatorFoodStrategyInterface
{
    public function build(): FoodInterface;
}
