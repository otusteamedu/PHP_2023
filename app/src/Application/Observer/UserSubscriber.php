<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\Observer;

use AYamaliev\Hw16\Domain\Entity\ProductInterface;
use AYamaliev\Hw16\Domain\Entity\User;
use AYamaliev\Hw16\Domain\Observer\SubscriberInterface;

class UserSubscriber implements SubscriberInterface
{
    public function __construct(private User $user)
    {
    }

    public function update(ProductInterface $product): void
    {
        echo "Оповещение покупателя {$this->user->getUsername()}" . PHP_EOL;
    }
}
