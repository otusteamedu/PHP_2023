<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Subscriber;

use DEsaulenko\Hw19\Report\ReportInterface;
use DEsaulenko\Hw19\Telegram\TelegramNotify;

class SubscriberTelegramNotification implements SubscriberObserverInterface
{
    private int $chatId;

    /**
     * @param int $chatId
     */
    public function __construct(int $chatId)
    {
        $this->chatId = $chatId;
    }

    public function update(ReportInterface $report): void
    {
        (new TelegramNotify($this->chatId))->notify($report->makeReport());
    }
}
