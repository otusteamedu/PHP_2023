<?php

namespace Dmitry\Hw16\Application\UseCase;

use Dmitry\Hw16\Application\Services\CookingInterface;
use Dmitry\Hw16\Domain\Entity\ProductInterface;

class CookingUseCase
{
    public function __invoke(
        CookingInterface $cookingService,
        ProductInterface ...$product
    ) {
        foreach ($product as $item) {
            $cookingService->cook($item);
        }
    }
}
