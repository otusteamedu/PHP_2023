<?php

namespace Rabbit\Daniel\Notification;

use Telegram\Bot\Api;

class TelegramNotification implements NotificationInterface
{
    private Api $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function send(string $to, string $message, array $options = []): bool
    {
        try {
            $this->telegram->sendMessage([
                'chat_id' => $to,
                'text' => $message
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}