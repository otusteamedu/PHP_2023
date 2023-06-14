<?php

declare(strict_types=1);

namespace Otus\App\Chat;

use Otus\App\Finder\Finder;
use Otus\App\Socket\SocketConfiguration;
use Otus\App\Socket\SocketManager;

final readonly class Server implements ChatInterface
{
    public function __construct(
        private Finder $finder,
        private SocketConfiguration $socketConfiguration,
        private SocketManager $socketManager,
    ) {
    }

    public function start(): void
    {
        $socket = $this->socketManager->create();
        $socketPath = $this->socketConfiguration->getSocketPath();

        $this->finder->delete($socketPath);

        $this->socketManager->bind($socket, $socketPath);
        $this->socketManager->listen($socket);

        $clientSocket = $this->socketManager->accept($socket);

        while (true) {
            $data = $this->socketManager->read($clientSocket);

            if ($data === 'exit') {
                break;
            }

            fwrite(STDOUT, "Received: $data\n");

            $confirmation = sprintf("Received %d bytes", strlen($data));
            $this->socketManager->write($clientSocket, $confirmation);
        }

        $this->socketManager->close($clientSocket);
        $this->socketManager->close($socket);

        $this->finder->delete($socketPath);
    }
}