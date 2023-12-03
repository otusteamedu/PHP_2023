<?php

namespace Radovinetch\Chat\Command;

use Radovinetch\Chat\Socket\Client;

class ClientCommand extends Command
{
    protected string $name = 'client';

    public function execute(array $args): void
    {
        $this->utils->log('Запускаем клиента');

        $client = new Client($this->utils);
        $client->run();
    }
}