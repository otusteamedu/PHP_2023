<?php

declare(strict_types=1);

namespace EEvstifeev\Chat;

use EEvstifeev\Chat\Contracts\HandlerContract;

final class ClientHandler implements HandlerContract
{
    public function handle(Socket $socket): void
    {
        $socket->connectSocket();
        while (true) {
            echo 'Сообщение: ';
            $input = readline();
            $socket->writeSocket($input);
        }
    }
}
