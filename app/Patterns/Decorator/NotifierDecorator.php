<?php
declare(strict_types=1);

namespace Decorator;

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
