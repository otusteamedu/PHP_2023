<?php

declare(strict_types=1);

namespace Imitronov\Hw7\UseCase\SocketClient;

use Imitronov\Hw7\Component\Socket;
use Imitronov\Hw7\Exception\SocketException;

final class CreateSocketClient
{
    /**
     * @throws SocketException
     */
    public function handle(CreateSocketClientInput $input): void
    {
        $messageHandler = $input->getMessageHandler();

        $socket = Socket::create();
        $socket->connect($input->getHost());
        $messageReader = $input->getMessageReader();

        while (true) {
            $message = $messageReader();

            if ('' === $message) {
                continue;
            }

            $socket->write($message);

            if (in_array($message, ['/exit', '/stop'], true)) {
                break;
            }

            $messageFromServer = $socket->read();
            $messageHandler($messageFromServer);
        }

        $socket->close();
    }
}
