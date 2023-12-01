<?php
declare(strict_types=1);

namespace Elena\Hw6;

use Exception;

class Client
{
    public function action(Socket $socket)
    {
        $message_class = new Message();
        $sock = $socket->create();
        $socket->connect($sock);

        while(true){
            $message = $message_class->get_message();
            $socket->write($sock, $message);
            echo ' Отправлено ' . $message. PHP_EOL;
            $data = $socket->read($sock);
            echo ' Ответ сервера: ' . $data . PHP_EOL;
        }
    }
 }
