<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Notification;

interface NotifierInterface
{
    public function sendNotification($message): void;
}
