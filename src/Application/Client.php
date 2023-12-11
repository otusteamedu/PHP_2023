<?php

declare(strict_types=1);

namespace Dimal\Hw6\Application;

use Dimal\Hw6\Socket;

class Client
{
    private Socket $socket;

    public function __construct(string $socket)
    {
        $this->socket = new Socket($socket);
        $this->socket->createClientSocket();
    }

    public function sendMsg(string $msg)
    {
        $this->socket->sendToServer($msg);
        $ret = $this->socket->listen();
        echo "Respone from server: $ret\n";
    }
}
