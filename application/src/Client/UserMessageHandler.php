<?php

declare(strict_types=1);

namespace Gesparo\Hw\Client;

class UserMessageHandler
{
    public function read(): string
    {
        return readline('Your message: ');
    }

    public function write(string $message): void
    {
        echo $message;
    }
}