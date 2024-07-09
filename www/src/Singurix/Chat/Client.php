<?php

declare(strict_types=1);

namespace Singurix\Chat;

use Exception;

class Client
{
    /**
     * @throws Exception
     */
    public function start(SocketChat $socketChat): void
    {
        $socketChat->isServerRun()->create()->connect();
        Stdout::printToConsole("Connected to server successful", true);
        Stdout::printToConsole("To stop the client, type 'stop'", true);
        while (true) {
            $consoleMessage = fgets(STDIN);
            if (trim($consoleMessage) == 'stop') {
                break;
            }
            $socketChat->write($consoleMessage);
            $message = $socketChat->read();
            Stdout::printToConsole($message);
        }
    }
}
