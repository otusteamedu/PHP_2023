<?php

declare(strict_types=1);

namespace Singurix\Chat;

class Client
{

    /**
     * @throws \Exception
     */
    public function start(): void
    {
        $clientStarted = true;
        $sock = (new SocketChat())->isServerRun()->create()->connect();
        Stdout::printToConsole("Connected to server successful", true);
        Stdout::printToConsole("To stop the client, type 'stop'", true);
        while ($clientStarted) {
            $consoleMessage = fgets(STDIN);
            if (trim($consoleMessage) == 'stop') {
                $clientStarted = false;
            } else {
                socket_write($sock->socket, $consoleMessage, strlen($consoleMessage));
                $message = socket_read($sock->socket, 2048);
                Stdout::printToConsole($message);
            }
        }
    }
}