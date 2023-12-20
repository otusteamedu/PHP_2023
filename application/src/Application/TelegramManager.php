<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class TelegramManager
{
    public function __construct(private readonly EnvManager $envManager)
    {
    }

    /**
     * @throws TelegramException
     */
    public function sendMessage(string $message): void
    {
        Request::sendMessage([
            'chat_id' => $this->envManager->getTelegramChatId(),
            'text' => $message,
        ]);
    }
}
