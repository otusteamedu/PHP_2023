<?php

namespace src\infrastructure\portAdapter;

use src\domain\event\fabric\IoCEvent;
use src\domain\subscriber\fabric\IoCSubscriber;
use src\domain\user\fabric\IoCUser;
use src\infrastructure\repository\Repository;

class ControllerToRepository
{
    public static function getSubscribers(
        Repository $repository,
        string $user,
        string $event
    ): array {
        return $repository->getSubscribersForUser(
            IoCEvent::create($event),
            IoCUser::create($user)
        );
    }

    public static function addSubscriberByEventForUser(
        Repository $repository,
        string $user,
        string $event,
        string $subscriber
    ): void {
        $repository->addSubscriberByEventForUser(
            IoCSubscriber::create($subscriber),
            IoCEvent::create($event),
            IoCUser::create($user)
        );
    }
}
