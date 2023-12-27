<?php

declare(strict_types=1);

namespace Chernomordov\App\Chat;

use Generator;

class Client extends Socket
{
    /**
     * @return Generator
     */
    protected function processChat(): Generator
    {
        while (true) {
            yield 'Введите сообщение: ';
            $this->write(readline());
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
