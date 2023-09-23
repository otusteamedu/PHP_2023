<?php

declare(strict_types=1);

namespace App\Music\Application\Observer\NewTrackObserver;

use App\Music\Domain\Entity\Track;

class AppNotifierService implements SubscriberInterface
{
    public function update(Track $track): void
    {
        echo 'Send to user device new track ' . $track->getName() . PHP_EOL;
    }
}
