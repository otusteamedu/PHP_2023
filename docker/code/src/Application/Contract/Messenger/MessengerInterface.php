<?php

namespace IilyukDmitryi\App\Application\Contract\Messenger;

interface MessengerInterface
{
    public function send(MessageInterface $message): void;

    public function recive(MessageInterface &$message): bool;
}
