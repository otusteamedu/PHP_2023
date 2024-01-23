<?php

namespace App\Application\Strategy;

use App\Domain\Entity\Contract\PublishAbleInterface;

class TelegramStrategy implements StrategyInterface
{
    public function notify(PublishAbleInterface $category): void
    {
        $observerEmails = $this->subscribers[$category->getId()] ?? [];

        foreach ($observerEmails as $observerEmail) {
            echo "Subscriber with email {$observerEmail} notified by telegram successfully.";
        }
    }
}
