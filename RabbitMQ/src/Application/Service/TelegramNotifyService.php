<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Contracts\NotifyServiceInterface;
use App\Application\Service\Exception\SendMessageException;
use Exception;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

readonly class TelegramNotifyService implements NotifyServiceInterface
{
    public function __construct(private ChatterInterface $chatter)
    {
    }

    /**
     * @throws SendMessageException
     * @throws TransportExceptionInterface
     */
    public function notify(string $chatId, string $message): void
    {
        try {
            $chatMessage = new ChatMessage($message);
            $telegramOptions = new TelegramOptions();
            $telegramOptions->chatId($chatId);
            $chatMessage->options($telegramOptions);

            $this->chatter->send($chatMessage);
        } catch (Exception) {
            throw new SendMessageException();
        }
    }
}
