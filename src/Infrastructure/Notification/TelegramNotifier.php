<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Notification;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class TelegramNotifier implements NotifierInterface
{
    private Telegram $telegram;
    private string $chatId;

    /**
     * @throws TelegramException
     */
    public function __construct(string $apiKey, string $botUsername, string $chatId)
    {
        $this->telegram = new Telegram($apiKey, $botUsername);
        $this->chatId = $chatId;
    }

    /**
     * @throws TelegramException
     */
    public function sendNotification($message): void
    {
        echo $this->chatId;
        Request::sendMessage([
            'chat_id' => $this->chatId,
            'text' => $message
        ]);
    }
}
