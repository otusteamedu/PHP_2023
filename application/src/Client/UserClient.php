<?php

declare(strict_types=1);

namespace Gesparo\Hw\Client;

use Gesparo\Hw\Socket\BaseSocket;

class UserClient extends BaseClient
{
    private UserMessageHandler $userMessageHandler;

    public function __construct(BaseSocket $socket)
    {
        parent::__construct($socket);

        $this->userMessageHandler = new UserMessageHandler();
    }

    public function handle(): void
    {
        $messageSocket = $this->socket->getMessageSocket();

        do {
            foreach ($messageSocket->read() as $message) {
                $this->userMessageHandler->write($message);
            }

            echo PHP_EOL;

            $userMessage = $this->userMessageHandler->read();
            $messageSocket->write($userMessage);

            if ($userMessage === 'quit' || $userMessage === 'shutdown') {
                break;
            }

            echo PHP_EOL;

            // waiting for response
            sleep(1);
        } while (true);
    }
}