<?php

declare(strict_types=1);

namespace App\Application\ViewModel;

final class SubscriptionViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $categoryId,
        public readonly string $userId,
    ) {
    }
}
