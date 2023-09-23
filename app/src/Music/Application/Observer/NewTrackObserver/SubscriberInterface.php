<?php

declare(strict_types=1);

namespace App\Music\Application\Observer\NewTrackObserver;

use App\Music\Domain\Entity\Track;

interface SubscriberInterface
{
    public function update(Track $track): void;
}
