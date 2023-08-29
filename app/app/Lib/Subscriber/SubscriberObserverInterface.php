<?php

declare(strict_types=1);

namespace App\Lib\Subscriber;

use App\Lib\Track\TrackObject;

interface SubscriberObserverInterface
{
    public function update(TrackObject $trackObject):void;
}
