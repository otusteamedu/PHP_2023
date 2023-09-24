<?php

declare(strict_types=1);

namespace EEvstifeev\Chat;

use EEvstifeev\Chat\Contracts\HandlerContract;

final class ServerHandler implements HandlerContract
{

    public function handle(Socket $socket): void
    {
        $socket->createSocket();
        $socket->bindSocket();

    }
}