<?php

namespace Rabbit\Daniel\Notification;

use Telegram\Bot\Api;

class TelegramNotification implements NotificationInterface {
    private $telegram;
    private $chatId;

    public function __construct(Api $telegram, $chatId) {
        $this->telegram = $telegram;
        $this->chatId = $chatId;
    }

    public function send($message) {
        $this->telegram->sendMessage([
            'chat_id' => $this->chatId,
            'text' => $message
        ]);
    }
}