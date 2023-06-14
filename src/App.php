<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Chat\ChatInterface;
use Otus\App\Chat\Client;
use Otus\App\Chat\Server;
use Otus\App\Finder\Finder;
use Otus\App\Socket\SocketConfiguration;
use Otus\App\Socket\SocketManager;

final class App
{
    public function run(): void
    {
        $chat = $this->resolveChat();

        $chat->start();
    }

    private function resolveChat(): ChatInterface
    {
        $chat = $_SERVER['argv'][1] ?? null;

        return match ($chat) {
            'server' => new Server(new Finder(), new SocketConfiguration(), new SocketManager()),
            'client' => new Client(new SocketConfiguration(), new SocketManager()),
            default => throw new \InvalidArgumentException('Such a type of chat is not supported'),
        };
    }
}
