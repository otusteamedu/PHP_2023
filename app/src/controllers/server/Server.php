<?php

declare(strict_types=1);

namespace nikitaglobal\controllers\server;

use nikitaglobal\Phrases;

/**
 * Class for getting incoming messages
 */
class Server
{
    /**
     * Listen socket
     */
    public function listen($socket): void
    {
        $socket->bind();
        $socket->listen();
        Phrases::show('waiting_messages');
        $client = $socket->accept();

        while (true) {
            $incomingData = $socket->receive($client);
            if ($incomingData['message'] === $socket->exitCommand) {
                Phrases::show('server_finish_chat');
                $socket->close($client);
                break;
            }
            Phrases::show('received_message', ['{message}' => $incomingData['message']]);
            $socket->write(Phrases::get('received_bytes', ['{bytes}' => $incomingData['bytes']]), $client);
        }

        $socket->close();
    }
}
