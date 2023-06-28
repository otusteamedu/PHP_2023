<?php
declare(strict_types=1);

interface Notifier
{
    public function send(string $message): string;
}

class EmailNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "Sending Email Notification: $message";
    }
}

class SlackNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "Sending Slack Notification: $message";
    }
}

class NotifierDecorator implements Notifier
{
    protected Notifier $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function send(string $message): string
    {
        return $this->notifier->send($message);
    }
}

class EncryptNotifierDecorator extends NotifierDecorator
{
    public function send(string $message): string
    {
        $encryptedMessage = $this->encryptMessage($message);
        return $this->notifier->send($encryptedMessage);
    }

    private function encryptMessage(string $message): string
    {
        return "Encrypted message: $message";
    }
}

$notifier = new EmailNotifier();
$notifier = new EncryptNotifierDecorator($notifier);
echo $notifier->send("Hello, World!");
