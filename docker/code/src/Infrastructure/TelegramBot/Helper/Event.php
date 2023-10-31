<?php


namespace IilyukDmitryi\App\Infrastructure\TelegramBot\Helper;

use IilyukDmitryi\App\Application\Result;
use IilyukDmitryi\App\Infrastructure\TelegramBot\Builder\EventDtoBuilder;
use Longman\TelegramBot\Entities\Message;

class Event
{
    public function __construct(protected Message $message)
    {
    }
    
    public function getOrCreateEvent(): Result
    {
        $eventDto = EventDtoBuilder::buildFromMessage($this->message);
        
    }
}