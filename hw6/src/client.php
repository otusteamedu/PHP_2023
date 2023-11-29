<?php
declare(strict_types=1);

namespace Elena\Hw6;

class Client
{
    public function action(Socket $socket){

        $message_class = new Message();
        $message = $message_class->get_message();

        $sock = $socket->create();
        $socket->connect($sock);
        socket_write($sock,$message);

       $socket->listen($sock);

        $socket = $socket->accept();
        while (true) {
            $data = $socket->receive($socket);
            echo $data . PHP_EOL;
            $answer = 'Получено: ' . mb_strlen($data) . PHP_EOL;
            $socket->write($answer, $socket);
            echo $answer;
        }
       $socket->$socket->close();
    }
}
