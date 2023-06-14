<?php

declare(strict_types=1);

namespace Otus\App\Chat;

use Otus\App\Socket\SocketConfiguration;
use Otus\App\Socket\SocketManager;

final readonly class Client implements ChatInterface
{
    public function __construct(
        private SocketConfiguration $socketConfiguration,
        private SocketManager $socketManager,
    ) {
    }

    public function start(): void
    {
        $socketPath = $this->socketConfiguration->getSocketPath();
        $socket = $this->socketManager->create();

        $this->socketManager->connect($socket, $socketPath);

        $input = '';
        while ($input !== 'exit') {
            $input = rtrim(fgets(STDIN));

            if (empty($input)) {
                fwrite(STDOUT, "Enter some message");
                continue;
            }

            $this->socketManager->write($socket, $input);
            $confirmation = $this->socketManager->read($socket);

            fwrite(STDOUT, "Confirmation: $confirmation\n");
        }

        $this->socketManager->close($socket);
    }
}