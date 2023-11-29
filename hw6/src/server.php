<?php
declare(strict_types=1);

namespace Elena\Hw6;

use Elena\Hw6\Socket;
use Exception;

class Server
{
    private $max_connect = 10;

    public function action(Socket $socket){
        $sock = $socket->create();
        $bind = $socket->bind($sock);
        $socket->listen($this->max_connect);

        $saccept = $socket->accept($sock);
        while (true) {
            $data = $socket->recv($sock, $saccept);
            echo $data . PHP_EOL;
            $answer = 'Получено: ' . mb_strlen($data) . PHP_EOL;
            $socket->write($answer, $sock);
            echo $answer;
        }
        $socket->close();
    }
}



