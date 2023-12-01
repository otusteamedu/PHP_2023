<?php
declare(strict_types=1);

namespace Elena\Hw6;

use Elena\Hw6\Socket;
use Exception;

class Server
{

   public function action(Socket $socket)
    {
        $sock = $socket->create(AF_UNIX, SOCK_STREAM, SOL_SOCKET);
        $socket->bind($sock);
        $socket->listen($sock);
        echo "wait". PHP_EOL;
        $accept = $socket->accept($sock);
        while(true){
          $data = $socket->read($accept);
          echo $data. PHP_EOL;
          $message = ' Получено ' . mb_strlen($data) . ' байт' . PHP_EOL;
          $socket->write($accept, $message);
          echo $message. PHP_EOL;
        }
    }

}



