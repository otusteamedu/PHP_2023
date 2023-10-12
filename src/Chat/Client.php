<?php

declare(strict_types=1);

namespace src\Chat;

use Generator;

class Client extends Socket
{
    protected function processChat(): Generator
    {
        while (true) {
            yield 'Type message and press Enter key: ';
            $this->write(readline());
            yield 'The server received ' . $this->read() . ' bytes.' . PHP_EOL;
        }
    }

    protected function initSocket(): void
    {
        $this->create();
        $this->connect();
    }
}
