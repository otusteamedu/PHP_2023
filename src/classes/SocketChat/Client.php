<?php

declare(strict_types=1);

namespace Klobkovsky\App\SocketChat;

use Generator;

class Client extends Socket
{
    /**
     * @return string
     */
    protected function getMode(): string
    {
        return 'client';
    }

    /**
     * @return Generator
     */
    protected function processChat(): Generator
    {
        while (true) {
            $this->write(readline('Cообщение: '));
            yield 'Received ' . $this->read() . ' bytes.' . PHP_EOL;
        }
    }

    /**
     * @return void
     */
    protected function initSocket(): void
    {
        $this->create();
        $this->connect();
    }
}
