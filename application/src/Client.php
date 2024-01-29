<?php

declare(strict_types=1);

namespace Chat;

use Exception;

class Client
{
    /**
     * @throws Exception
     */
    public static function handle(Chat $chat): void
    {
        $chat->create();
        $chat->connect();

        echo "Welcome to the socket chat! For exit - print 'exit'." . PHP_EOL . PHP_EOL;

        while (true) {
            $message = readline();
            if ($message === 'exit') {
                $chat->close();
                break;
            }

            $chat->write($message);
            $chat->read();
            if (!is_null($chat->clipboard['message'])) {
                echo $chat->clipboard['message'] . PHP_EOL;
            }
        }
    }
}
