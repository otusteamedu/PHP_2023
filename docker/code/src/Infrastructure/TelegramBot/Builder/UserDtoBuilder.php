<?php


namespace IilyukDmitryi\App\Infrastructure\TelegramBot\Builder;

use IilyukDmitryi\App\Application\Dto\UserRequestDto;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\Message;

class UserDtoBuilder
{
    public static function buildFromMessage(Message $message): UserRequestDto
    {
        $user = $message->getFrom();
        $userName = $user->getUsername()?:($user->getFirstName()) ;
        $userId = $user->getId();
        
        return new UserRequestDto($userName,$userId);
    }
    
    public static function buildFromCallback(CallbackQuery $callbackQuery): UserRequestDto
    {
        $userId = $callbackQuery->getFrom()->getId();
        $userName = $callbackQuery->getFrom()->getUsername()?:($callbackQuery->getFrom()->getFirstName());
        return new UserRequestDto($userName,$userId);
    }
}