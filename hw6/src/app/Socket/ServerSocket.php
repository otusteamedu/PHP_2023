<?php

namespace AShashkov\ConsoleSocketChat\Socket;

use Generator;

class ServerSocket extends Socket
{
    protected function processChat(): Generator
    {
        yield 'Awaiting for client message...' . PHP_EOL;

        $client = $this->accept();

        while (true) {
            $message = $this->receive($client);
            if (! is_null($message['message'])) {
                yield $message['message'] . PHP_EOL;

                $this->write($message['length'], $client);
            }
        }
    }

    protected function initSocket(): void
    {
        $this->create(true);
        $this->bind();
        $this->listen();
    }
}
