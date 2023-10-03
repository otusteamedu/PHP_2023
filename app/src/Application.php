<?php

declare(strict_types=1);

namespace Lebedevvr\Chat;

use Lebedevvr\Chat\Handler\ClientHandler;
use Lebedevvr\Chat\Handler\ServerHandler;
use Lebedevvr\Chat\Socket\Socket;

final class Application
{
    public function run($argv): void
    {
        try {
            if (!isset($argv[1]) || !in_array($argv[1], ['client', 'server'])) {
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
