<?php

declare(strict_types=1);

namespace Atsvetkov\Chat;

use Atsvetkov\Chat\Handler\ClientHandler;
use Atsvetkov\Chat\Handler\ServerHandler;
use Atsvetkov\Chat\Socket\Socket;

final class Application
{
    public function run($argv): void
    {
        try {
            if (!isset($argv[1])) {
                throw new \InvalidArgumentException('No client or server argument!');
            }

            switch ($argv[1]) {
                case 'client':
                    $handler = new ClientHandler();
                    $handler->handle(new Socket());
                    break;
                case 'server':
                    $handler = new ServerHandler();
                    $handler->handle(new Socket());
                    break;
            }
        } catch (\Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}
