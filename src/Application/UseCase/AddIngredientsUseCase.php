<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\Decorator\AddFillingDecorator;
use src\Domain\Repository\FoodRepositoryInterface;

class AddIngredientsUseCase
{
    public function __construct(private FoodRepositoryInterface $foodRepository)
    {
    }

    public function __invoke(int $foodId, string $ingredients): void
    {
        $food = $this->foodRepository->getById($foodId);
        $this->foodRepository->update(new AddFillingDecorator($food, $ingredients));
    }
}
