<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Subscription;
use App\Domain\ValueObject\Id;

interface SubscriptionRepositoryInterface
{
    public function nextId(): Id;

    /**
     * @return Subscription[]
     */
    public function partByCategoryId(Id $categoryId, Pagination $pagination): array;
}
