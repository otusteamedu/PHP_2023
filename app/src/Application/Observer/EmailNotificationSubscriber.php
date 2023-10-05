<?php

declare(strict_types=1);

namespace App\Application\Observer;

use App\Application\Component\EmailSender\EmailSenderInterface;
use App\Domain\Repository\Pagination;
use App\Domain\Repository\SubscriptionRepositoryInterface;
use App\Domain\ValueObject\NotEmptyString;

final class EmailNotificationSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
        private readonly EmailSenderInterface $emailSender,
    ) {
    }

    public function update(EventInterface $event): void
    {
        if (!$event instanceof NewsIsCreatedEvent) {
            return;
        }

        $news = $event->getObject();
        $message = new NotEmptyString('News has been added to the site.');
        $pagination = new Pagination(1, 20);

        do {
            $subscribers = $this->subscriptionRepository->partByCategoryId($event->getObject()->getCategory()->getId(), $pagination);

            foreach ($subscribers as $subscriber) {
                $this->emailSender->send(
                    $subscriber->getUser()->getEmail(),
                    $news->getTitle(),
                    $message,
                );
            }

            $pagination->iteratePage();
        } while (count($subscribers) === $pagination->getPerPage());
    }
}
