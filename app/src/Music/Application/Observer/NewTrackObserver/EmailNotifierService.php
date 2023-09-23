<?php

declare(strict_types=1);

namespace App\Music\Application\Observer\NewTrackObserver;

use App\Music\Domain\Entity\Track;

class EmailNotifierService implements SubscriberInterface
{
    public function update(Track $track): void
    {
        echo 'Send to user email new track ' . $track->getName() . PHP_EOL;
    }
}
