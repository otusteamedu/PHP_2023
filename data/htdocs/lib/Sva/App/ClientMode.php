<?php

namespace Sva\App;

use Exception;
use Sva\App\Socket\Connection;

class ClientMode
{
    /**
     * @throws Exception
     */
    public function start(): \Generator
    {
        if ($f = fopen('php://stdin', 'r')) {
            while (true) {
                yield "Введите сообщение для сервера\n> ";

                $message = trim(fgets($f));

                $connection = Connection::connect();
                $response = $connection
                    ->write($message)
                    ->read();

                yield $response . "\n";

                $connection->close();

                if ($message == 'exit') {
                    break;
                }
            }

            fclose($f);
        }
    }
}
