<?php

namespace AShashkov\ConsoleSocketChat\Socket;

use Generator;

class ClientSocket extends Socket
{
    protected function processChat(): Generator
    {
        while (true) {
            yield 'Type message and press Return key: ';
            $message = readline();
            $this->write($message);

            yield 'The server received ' . $this->read() . ' bytes.' . PHP_EOL;
        }
    }

    protected function initSocket(): void
    {
        $this->create();
        $this->connect();
    }
}
