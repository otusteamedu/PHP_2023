<?php

declare(strict_types=1);

namespace App\Application\UseCase\Subscription;

use App\Domain\Entity\Subscription;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Flusher;
use App\Domain\Repository\Persister;
use App\Domain\Repository\SubscriptionRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;

final class CreateSubscription
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
        private readonly Persister $persister,
        private readonly Flusher $flusher,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function handle(CreateSubscriptionInput $input): Subscription
    {
        $category = $this->categoryRepository->firstOrFailById($input->getCategoryId());
        $user = $this->userRepository->firstOrFailById($input->getUserId());
        $subscription = new Subscription(
            $this->subscriptionRepository->nextId(),
            $category,
            $user,
        );
        $this->persister->persist($subscription);
        $this->flusher->flush();

        return $subscription;
    }
}
