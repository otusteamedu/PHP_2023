<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Subscription\Create;

use App\Application\Presenter\SubscriptionPresenter;
use App\Application\UseCase\Subscription\CreateSubscription;
use App\Application\UseCase\Subscription\CreateSubscriptionInput;
use App\Domain\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateSubscriptionController extends AbstractController
{
    public function __construct(
        private readonly CreateSubscription $createSubscription,
        private readonly SubscriptionPresenter $subscriptionPresenter,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function handle(CreateSubscriptionInput $input): JsonResponse
    {
        $subscription = $this->createSubscription->handle($input);

        return new JsonResponse([
            'data' => $this->subscriptionPresenter->present($subscription),
        ]);
    }
}
