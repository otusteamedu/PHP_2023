<?php

namespace Sva\App;

use Generator;
use Exception;

class ServerMode
{
    protected bool $running = false;

    /**
     * @return Generator
     * @throws Exception
     */
    public function start(): Generator
    {
        $socketManager = new Socket\Manager();
        yield "Waiting connections...\n";

        while (true) {
            $socketConnection = $socketManager->acceptConnection();
            yield "Client is connected...\n";

            $message = $socketConnection->read();

            $response = "Получено сообщение(" . strlen($message) . " байт): " . $message;
            yield $response . "\n";

            $socketConnection->write($response);
            $socketConnection->close();
            yield "Client is disconnected...\n";

            if ($message == 'exit') {
                yield "Message is \"exit\" exiting...\n";
                break;
            }
        }

        $socketManager->close();
    }
}
