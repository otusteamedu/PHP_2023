<?php

declare(strict_types=1);

namespace Singurix\Chat;

use Exception;

class Client
{
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
        $this->socketChat->isServerRun()->create()->connect();
        Stdout::printToConsole("Connected to server successful", true);
        Stdout::printToConsole("To stop the client, type 'stop'", true);
        while (true) {
            $consoleMessage = fgets(STDIN);
            if (trim($consoleMessage) == 'stop') {
                break;
            }
            $this->socketChat->write($consoleMessage);
            $message = $this->socketChat->read();
            Stdout::printToConsole($message);
        }
    }
}
