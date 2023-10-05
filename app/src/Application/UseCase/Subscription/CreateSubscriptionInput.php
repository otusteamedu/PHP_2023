<?php

declare(strict_types=1);

namespace App\Application\UseCase\Subscription;

use App\Domain\ValueObject\Id;

interface CreateSubscriptionInput
{
    public function getCategoryId(): Id;

    public function getUserId(): Id;
}
