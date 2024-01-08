<?php

declare(strict_types=1);

namespace App\Application\Component;

use App\Entity\ValueObject\ChatId;

interface TelegramSenderInterface
{
    public function send(ChatId $chatId, string $message): void;
}
