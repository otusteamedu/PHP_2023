<?php


namespace IilyukDmitryi\App\Infrastructure\TelegramBot\Builder;

use IilyukDmitryi\App\Application\Dto\EventRequestDto;
use Longman\TelegramBot\Entities\Message;

class EventDtoBuilder
{
    public static function buildFromMessage(Message $message): EventRequestDto
    {
        $chat = $message->getChat();
        $chatId = $chat->getId();
        $chatName = $chat->getTitle() ?: $chat->getUsername();
        return new EventRequestDto($chatName, $chatId);
    }
}