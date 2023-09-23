<?php

declare(strict_types=1);

namespace App\Music\Application\Observer\NewTrackObserver;

use App\Music\Domain\Entity\Track;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;

    public function unsubscribe(SubscriberInterface $subscriber): void;

    public function notify(Track $track): void;
}