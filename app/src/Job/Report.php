<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Job;

use DEsaulenko\Hw19\Report\ReportExampleBuilder;
use DEsaulenko\Hw19\Report\ReportInterface;
use DEsaulenko\Hw19\Subscriber\SubscriberObserverInterface;
use DEsaulenko\Hw19\Subscriber\SubscriberTelegramNotification;
use SplObjectStorage;

class Report
{
    private SplObjectStorage $observers;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function execute(array $data): void
    {
        $report = (new ReportExampleBuilder())->build($data);
        $this->notify($report);
    }

    public function attach(SubscriberObserverInterface $observer): self
    {
        $this->observers->attach($observer);
        return $this;
    }

    public function detach(SubscriberObserverInterface $observer): self
    {
        $this->observers->detach($observer);
        return $this;
    }

    public function notify(ReportInterface $report): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($report);
        }
    }
}