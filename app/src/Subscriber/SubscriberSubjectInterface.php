<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Subscriber;

use DEsaulenko\Hw19\Report\ReportInterface;

interface SubscriberSubjectInterface
{
    public function attach(SubscriberObserverInterface $observer);
    public function detach(SubscriberObserverInterface $observer);
    public function notify(ReportInterface $report);
}
