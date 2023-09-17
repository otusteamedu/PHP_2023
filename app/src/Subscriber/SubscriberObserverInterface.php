<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Subscriber;

use DEsaulenko\Hw19\Report\ReportInterface;

interface SubscriberObserverInterface
{
    public function update(ReportInterface $report): void;
}