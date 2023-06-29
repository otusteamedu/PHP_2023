<?php
declare(strict_types=1);

namespace Decorator;

class SlackNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "Sending Slack Notification: $message";
    }
}
