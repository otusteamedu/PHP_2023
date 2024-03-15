<?php

declare(strict_types=1);

namespace Klobkovsky\App\SocketChat;

use Generator;

class Server extends Socket
{
    /**
     * @return string
     */
    protected function getMode(): string
    {
        return 'server';
    }

    /**
     * @return Generator
     */
    protected function processChat(): Generator
    {
        while (true) {
            $client = $this->accept();

            while (true) {
                $message = $this->receive($client);

                if (!is_null($message['message'])) {
                    yield $message['message'] . PHP_EOL;
                    $this->write((string)$message['length'], $client);
                } else {
                    unset($client);
                    break;
                }
            }
        }
    }

    /**
     * @return void
     */
    protected function initSocket(): void
    {
        $this->create();
        $this->bind();
        $this->listen();
    }
}
