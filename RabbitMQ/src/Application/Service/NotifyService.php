<?php

namespace App\Application\Service;

use App\Application\Service\Exception\SendMessageException;
use App\Entity\ValueObject\ChatId;
use Exception;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

readonly class NotifyService
{
    public function __construct(private ChatterInterface $chatter)
    {
    }

    /**
     * @throws SendMessageException
     * @throws TransportExceptionInterface
     */
    public function sendMessage(string $chatId, string $message): void
    {
        try {
            $chatMessage = new ChatMessage($message);
            $telegramOptions = new TelegramOptions();
            $telegramOptions->chatId($chatId);
            $chatMessage->options($telegramOptions);

            $this->chatter->send($chatMessage);
        } catch (Exception $exception) {
            throw new SendMessageException($exception);
        }
    }
}
