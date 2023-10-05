<?php

declare(strict_types=1);

namespace App\Infrastructure\Component\EmailSender;

use App\Application\Component\EmailSender\EmailSenderInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;
use Psr\Log\LoggerInterface;

final class EmailSender implements EmailSenderInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function send(Email $receiver, NotEmptyString $subject, NotEmptyString $message): void
    {
        // Для простоты имитируем отправку письма.
        $this->logger->info(sprintf(
            "EMAIL !!!\n%s\n%s\n%s",
            $receiver,
            $subject,
            $message,
        ));
    }
}
