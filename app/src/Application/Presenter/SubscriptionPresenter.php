<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Application\ViewModel\SubscriptionViewModel;
use App\Domain\Entity\Subscription;

final class SubscriptionPresenter
{
    public function __construct(
        private readonly IdPresenter $idPresenter,
    ) {
    }

    public function present(Subscription $subscription): SubscriptionViewModel
    {
        return new SubscriptionViewModel(
            $this->idPresenter->present($subscription->getId()),
            $this->idPresenter->present($subscription->getCategory()->getId()),
            $this->idPresenter->present($subscription->getUser()->getId()),
        );
    }
}
