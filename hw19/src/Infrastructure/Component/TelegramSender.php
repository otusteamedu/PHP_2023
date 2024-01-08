<?php

declare(strict_types=1);

namespace App\Infrastructure\Component;

use App\Application\Component\TelegramSenderInterface;
use App\Entity\ValueObject\ChatId;
use Psr\Log\LoggerInterface;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class TelegramSender implements TelegramSenderInterface
{
    public function __construct(
        private readonly ChatterInterface $chatter,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function send(ChatId $chatId, string $message): void
    {
        $this->logger->info(
            sprintf(
                '%s',
                $message
            ),
        );
        try {
            $chatMessage = new ChatMessage($message);
            $telegramOptions = (new TelegramOptions())->chatId($chatId->getValue());
            $chatMessage->options($telegramOptions);

            $this->chatter->send($chatMessage);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
