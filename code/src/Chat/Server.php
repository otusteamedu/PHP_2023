<?php

declare(strict_types=1);

namespace Propan13\App\Chat;

use Generator;

class Server extends Socket
{
    public function init(): void
    {
        $this->create();
        $this->bind(true);
        $this->listen();
    }

    public function launch(): Generator
    {
        yield('Ожидаем сообщения' . PHP_EOL);
        $client = $this->accept();
        while (true) {
            $message = $this->receive($client);
            if ($message) {
                yield $message . PHP_EOL;
                $this->write((string)strlen($message), $client);
            }
        }
    }
}
