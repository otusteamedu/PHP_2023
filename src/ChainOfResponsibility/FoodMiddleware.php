<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility;

use App\Builder\FoodInterface;

readonly class FoodMiddleware
{
    public function __construct(private FoodHandler $foodHandler)
    {
    }

    public function do(FoodInterface $food): void
    {
        $this->foodHandler->handle($food);
    }
}
