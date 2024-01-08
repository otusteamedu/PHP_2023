<?php

declare(strict_types=1);

namespace Chat;

use Exception;

final class Server
{
    /**
     * @throws Exception
     */
    public static function processing(Chat $chat): void
    {
        $chat->create();
        $chat->bind();
        $chat->listen();

        echo "waiting for clients to connect..." . PHP_EOL;

        $chat->accept();

        echo "client connecting!" . PHP_EOL;

        while (true) {
            $chat->receive();

            if (is_null($chat->buf['message'])) {
                continue;
            }

            echo $chat->buf['message'] . PHP_EOL;

            if ($chat->buf['message'] == 'exit') {
                break;
            }

            $message = 'Server received ' . $chat->buf['length'] . ' bytes';
            $chat->write($message);
        }
    }
}


//        do {
//            $chat->accept();
//            $chat->write($chat->startMessage);
//
//            do {
//                echo 'do-do';
//                $chat->read();
//
//                if (!$chat->buf) {
//                    continue;
//                }
//
//                if ($chat->buf === 'off') {
//                    $chat->close();
//                    break 2;
//                }
//                $talkback = "PHP: Вы сказали $chat->buf" . PHP_EOL;
//
//                $chat->write($talkback);
//                echo "$chat->buf\n";
//            } while (true);
//
//            $chat->close();
//        } while (true);
//
//        $chat->close();
