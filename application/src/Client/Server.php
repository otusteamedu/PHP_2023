<?php

declare(strict_types=1);

namespace Gesparo\Hw\Client;

class Server extends BaseClient
{
    public function handle(): void
    {
        do {
            $messageSocket = $this->socket->getMessageSocket();

            $messageSocket->write(
                <<<EOL
                    Welcome to the PHP Socket Server.
                    To quit, type 'quit'. To shut down the server type 'shutdown'.
                EOL
            );

            while (true) {
                sleep(1);

                $bytes = 0;

                foreach ($messageSocket->read() as $message) {
                    echo "DEBUG: Message is '$message'" . PHP_EOL;

                    if ($bytes === 0 && $message === 'quit') {
                        break 2;
                    }

                    if ($bytes === 0 && $message === 'shutdown') {
                        break 3;
                    }

                    $bytes += strlen($message);
                }

                if ($bytes > 0) {
                    $messageSocket->write("Server response: Received $bytes bytes\n");
                }
            }
        } while (true);
    }
}
