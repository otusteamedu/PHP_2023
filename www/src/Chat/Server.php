<?php

declare(strict_types=1);

namespace Chernomordov\App\Chat;

use Generator;

class Server extends Socket
{
    /**
     * @return Generator
     */
    protected function processChat(): Generator
    {
        yield 'Ждем сообщения' . PHP_EOL;

        $client = $this->accept();

        while (true) {
            $message = $this->receive($client);
            if (!is_null($message['message'])) {
                yield $message['message'] . PHP_EOL;

                $this->write((string)$message['length'], $client);
            }
        }
    }

    /**
     * @return void
     */
    protected function initSocket(): void
    {
        $this->create(true);
        $this->bind();
        $this->listen();
    }
}
