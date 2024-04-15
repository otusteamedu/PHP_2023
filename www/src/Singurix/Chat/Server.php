<?php

declare(strict_types=1);

namespace Singurix\Chat;

use Exception;

class Server
{

    public bool $serverStarted;

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $sock = (new SocketChat())
            ->create()
            ->bind()
            ->listen();
        socket_set_nonblock($sock->socket);
        Stdout::printToConsole('Server started at ' . date('H:i:s'));
        Stdout::printToConsole("To stop the server, type 'stop'", true);
        $this->serverStarted = true;
        $this->readMessage($sock);
    }

    private function checkStop(): void
    {
        $stdIn = fopen("php://stdin", 'r');
        stream_set_blocking($stdIn, false);
        $message = fgets($stdIn);
        if ($message && trim($message) == 'stop') {
            $this->serverStarted = false;
        }
    }

    private function readMessage($sock): void
    {
        $socketMsg = false;
        do {
            if($socketMsg) {
                socket_set_nonblock($socketMsg);
                if($message = socket_read($socketMsg, 2048)) {
                    Stdout::printToConsole('Incoming message - ' . $message);
                    socket_write($socketMsg, 'Received ' . strlen($message) . ' bytes');
                }
            } else {
                $socketMsg = socket_accept($sock->socket);
            }
            $this->checkStop();
        } while ($this->serverStarted);
        Stdout::printToConsole('Server stopped at ' . date('H:i:s'), true);
        $sock->close();
    }
}
