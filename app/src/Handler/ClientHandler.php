<?php

declare(strict_types=1);

namespace Lebedevvr\Chat\Handler;

use Lebedevvr\Chat\Socket\Socket;

class ClientHandler implements HandlerInterface
{
    public function handle(Socket $socket): void
    {
        $socket->create();
        $socket->connect();
        while (true) {
            echo 'Сообщение: ';
            $input = readline();
            $socket->write($input);
            echo 'The server received ' . $socket->read() . ' bytes.' . PHP_EOL;
        }
    }
}
