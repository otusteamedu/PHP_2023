<?php

declare(strict_types=1);

namespace App\Observer;

use App\Builder\FoodInterface;

interface CookingStatusObserverInterface
{
    public function update(FoodInterface $food, string $status);
}
