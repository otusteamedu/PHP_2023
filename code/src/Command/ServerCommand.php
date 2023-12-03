<?php

namespace Radovinetch\Chat\Command;

use http\Exception\RuntimeException;
use Radovinetch\Chat\Socket\Server;

class ServerCommand extends Command
{
    protected string $name = 'server';

    public function execute(array $args): void
    {
        $this->utils->log('Запускаем сервер');

        $server = new Server($this->utils);
        $server->run();
    }
}