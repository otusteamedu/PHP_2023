<?php

declare(strict_types=1);

namespace Dimal\Hw6\Application;

use Dimal\Hw6\Socket;

class Server
{
    private Socket $socket;

    public function __construct(string $socket)
    {
        $this->socket = new Socket($socket);
        $this->socket->createServerSocket();
    }

    public function observe()
    {
        echo "Start listen\n";
        while (true) {
            $ret = $this->socket->listen();
            echo "Received: $ret\n";
            $this->socket->sendAnswer("received: " . strlen($ret) . " bytes");
        }
    }
}
