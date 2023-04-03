<?php

declare(strict_types=1);

namespace Imitronov\Hw7\UseCase\SocketServer;

use Imitronov\Hw7\Component\Socket;
use Imitronov\Hw7\Exception\SocketException;

final class CreateSocketServer
{
    /**
     * @throws SocketException
     */
    public function handle(CreateSocketServerInput $input): void
    {
        $socket = Socket::create();
        $socket->bind($input->getHost());
        $socket->listen($input->getBacklog());
        $messageHandler = $input->getMessageHandler();

        while (true) {
            $client = $socket->accept();

            while (true) {
                $message = $client->read();

                if ("" === $message) {
                    continue;
                }

                if ("/exit" === $message) {
                    break;
                }

                if ("/stop" === $message) {
                    break 2;
                }

                $messageHandler($message);
                $client->write("Received " . strlen($message) . " bytes");
            }
        }

        $socket->close();
    }
}
