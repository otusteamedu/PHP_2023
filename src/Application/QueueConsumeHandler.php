<?php

declare(strict_types=1);

namespace User\Php2023\Application;

use User\Php2023\Domain\Interfaces\QueueConsumeHandlerInterface;
use User\Php2023\Infrastructure\Notification\NotifierInterface;

class QueueConsumeHandler implements QueueConsumeHandlerInterface
{
    public function __construct(readonly private NotifierInterface $notifier)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle($message): void
    {
        $requestID = random_int(10_000, 9_99_999);
        $this->notifier->sendNotification(
            "Сообщение обработано: " . PHP_EOL .
            "Заявка № $requestID" . PHP_EOL .
            $message);
    }
}
