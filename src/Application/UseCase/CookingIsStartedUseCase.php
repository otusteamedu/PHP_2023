<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\Publisher\PublisherInterface;
use src\Domain\Repository\FoodRepositoryInterface;

class CookingIsStartedUseCase
{
    public function __construct(private FoodRepositoryInterface $foodRepository, private PublisherInterface $publisher)
    {
    }

    public function __invoke(int $foodId): void
    {
        $food = $this->foodRepository->getById($foodId);
        //меняем статус если все ок то отправится уведомление
        $this->publisher->notify($food, 'cooking is started');
    }
}
