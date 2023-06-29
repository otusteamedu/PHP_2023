<?php
declare(strict_types=1);

namespace Decorator;

class EmailNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "Sending Email Notification: $message";
    }
}
