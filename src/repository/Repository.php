<?php

namespace src\repository;

use src\event\EventInterface;
use src\fabric\IoCSubscriber;
use src\log\Log;
use src\subscriber\SubscriberInterface;
use src\user\UserInterface;

class Repository
{
    private array $subscribersByEventForUser;

    public function addSubscriberByEventForUser(
        SubscriberInterface $subscriber,
        EventInterface $event,
        UserInterface $user
    ): void {
        $message = 'Log:: subscriber(' . $subscriber->getType() . ')' . 'event(' . $event->getType() . ')' . 'user(' . $user->getId() . ')';
        Log::info($message);

        $this->subscribersByEventForUser[$user->getId()][$event->getType()][] = $subscriber;

        $exec = InsertCommand::build()
            ->setUserId($user->getId())
            ->setEventType($event->getType())
            ->setSubscriberType($subscriber->getType())
            ->execute();
        $message = ':og:: exec(' . ($exec ? '+' : '-') . ')';
        Log::info($message);
    }

    public function getSubscribersForUser(
        EventInterface $event,
        UserInterface $user
    ): array {
        $data = ServiceFetchDataQuery::build()
            ->setUserId($user->getId())
            ->setEventType($event->getType())
            ->fetchData();

        foreach ($data as $userId => $typeEventWithSubscribers) {
            foreach ($typeEventWithSubscribers as $eventType => $subscribers) {
                foreach ($subscribers as $subscriber) {
                    $this->subscribersByEventForUser[$userId][$eventType][] = IoCSubscriber::create($subscriber);
                }
            }
        }

        $subscribers = $this->subscribersByEventForUser[$user->getId()][$event->getType()] ?? [];
        $subscribers = array_unique($subscribers, SORT_REGULAR);

        return $subscribers;
    }
}
