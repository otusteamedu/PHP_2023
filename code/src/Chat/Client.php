<?php

namespace Propan13\App\Chat;

use Generator;

class Client extends Socket
{
    public function init(): void
    {
        $this->create();
        $this->connect();
    }

    public function launch(): Generator
    {
        while (true) {
            yield 'Введите сообщение: ';
            $this->write(readline());
            yield 'Received ' . $this->read() . PHP_EOL;
        }
    }
}