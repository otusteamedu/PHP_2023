<?php
declare(strict_types=1);

namespace Decorator;

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