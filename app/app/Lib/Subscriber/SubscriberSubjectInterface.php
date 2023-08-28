<?php

declare(strict_types=1);

namespace App\Lib\Subscriber;

use App\Lib\Track\TrackObject;

interface SubscriberSubjectInterface
{
    public function attach(SubscriberObserverInterface $observer);
    public function detach(SubscriberObserverInterface $observer);
    public function notify(TrackObject $trackObject);
}
