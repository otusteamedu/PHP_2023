<?php

declare(strict_types=1);

namespace Chat;

use Exception;

class Server
{
    /**
     * @throws Exception
     */
    public static function handle(Chat $chat): void
    {
        $chat->create();

        $chat->bind();

        $chat->listen();

        echo "Waiting for clients to connect ..." . PHP_EOL;

        $chat->accept();

        echo "Client connected!" . PHP_EOL;

        while (true) {
            $chat->receive();

            if (is_null($chat->clipboard['message'])) {
                continue;
            }

            echo $chat->clipboard['message'] . PHP_EOL;

            if ($chat->clipboard['message'] === 'exit') {
                break;
            }

            $message = 'Server received ' . $chat->clipboard['length'] . ' bytes';

            $chat->write($message);
        }
    }
}
