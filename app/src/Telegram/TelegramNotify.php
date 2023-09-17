<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Telegram;

use DEsaulenko\Hw19\Interfaces\NotifyInterface;

class TelegramNotify implements NotifyInterface
{
    private int $chatId;

    public function __construct(int $chatId)
    {
        $this->chatId = $chatId;
    }

    public function notify(string $text): void
    {
        TelegramClient::getInstance()->post($this->chatId, $text);
    }
}
