<?php

declare(strict_types=1);

namespace Singurix\Chat;

use Exception;

class Server
{
    public bool $serverStarted;
    private SocketChat $socketChat;

    public function __construct(SocketChat $socketChat)
    {
        $this->socketChat = $socketChat;
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->socketChat->startServer();
        $this->readMessage();
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

    private function readMessage(): void
    {
        $this->serverStarted = true;
        Stdout::printToConsole('Server started at ' . date('H:i:s'));
        Stdout::printToConsole("To stop the server, type 'stop'", true);

        do {
            if($this->socketChat->accept()) {
                break;
            }
            $this->checkStop();
        } while ($this->serverStarted);

        while ($this->serverStarted) {
            if ($this->socketChat->isConnected()) {
                $this->socketChat->setNonBlock();
                if ($message = $this->socketChat->read(true)) {
                    Stdout::printToConsole('Incoming message - ' . $message);
                    $this->socketChat->write('Received ' . strlen($message) . ' bytes', true);
                }
            }
            $this->checkStop();
        }

        Stdout::printToConsole('Server stopped at ' . date('H:i:s'), true);
        $this->socketChat->close();
    }
}
