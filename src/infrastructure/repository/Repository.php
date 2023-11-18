<?php

namespace src\infrastructure\repository;

use src\domain\subscriber\fabric\IoCSubscriber;
use src\domain\event\EventInterface;
use src\domain\subscriber\SubscriberInterface;
use src\domain\user\UserInterface;
use src\infrastructure\log\LogInterface;
use src\infrastructure\repository\exception\UnableToExecuteStatementDBException;

class Repository
{
    private array $subscribersByEventForUser;
    private LogInterface $log;

    public function __construct(LogInterface $log)
    {
        $this->log = $log;
    }

    public function addSubscriberByEventForUser(
        SubscriberInterface $subscriber,
        EventInterface $event,
        UserInterface $user
    ): void {
        $messageInfo = 'subscriber(' . $subscriber->getType() . ')' . 'event(' . $event->getType() . ')' . 'user(' . $user->getId() . ')';
        $this->log->info($messageInfo);

        $this->subscribersByEventForUser[$user->getId()][$event->getType()][] = $subscriber;

        $exec = InsertCommand::build()
            ->setUserId($user->getId())
            ->setEventType($event->getType())
            ->setSubscriberType($subscriber->getType())
            ->execute();

        $this->log->info('::db-insert:: exec(' . ($exec ? 'true' : 'false') . ')');
        if (!$exec) {
            $this->log->error('try to insert to DB data: ' . $messageInfo);
            throw new UnableToExecuteStatementDBException($messageInfo, 500);
        }
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
