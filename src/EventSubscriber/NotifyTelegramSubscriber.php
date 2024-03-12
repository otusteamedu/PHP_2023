<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\SendNotifyTelegram;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

readonly class NotifyTelegramSubscriber implements EventSubscriberInterface
{
    public function __construct(private BotApi $bot)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [SendNotifyTelegram::class => 'sendNotify'];
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function sendNotify(SendNotifyTelegram $sendNotifyTelegram): void
    {
        $this->bot->sendMessage($sendNotifyTelegram->getUser()->getTelegramChatId(), $sendNotifyTelegram->getMessage());
    }
}
