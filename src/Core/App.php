<?php

declare(strict_types=1);

namespace Twent\Chat\Core;

use Exception;
use Twent\Chat\Servers\Client;
use Twent\Chat\Servers\Contracts\ServerContract;
use Twent\Chat\Servers\Server;
use Twent\Chat\Sockets\UnixSocketError;

final class App
{
    private Mode $mode;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (! isset($_SERVER['argv']) || count($_SERVER['argv']) !== 2) {
            throw new Exception('Передано неверное кол-во агрументов!');
        }

        $mode = Mode::tryFrom($_SERVER['argv'][1]);

        if (! $mode) {
            throw new Exception('Запуск с такими параметрами невозможен! Используйте "server" или "client"');
        }

        $this->mode = $mode;

        set_error_handler(fn () => true);
    }

    /**
     * @throws UnixSocketError
     */
    public function run(): void
    {
        $server = $this->getInstance();

        foreach ($server->run() as $line) {
            echo $line;
        }
    }

    private function getInstance(): ServerContract
    {
        return match ($this->mode) {
            Mode::Server => Server::getInstance(),
            Mode::Client => Client::getInstance(),
        };
    }
}
