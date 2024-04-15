<?php

declare(strict_types=1);

namespace Singurix\Chat;

class App
{
    public string $type;

    /**
     * @throws \Exception
     */
    public function __construct($argv)
    {
        if ($argv[1] == 'server-start') {
            $this->type = 'server';
            $server = new Server();
            $server->start();
        } elseif ($argv[1] == 'client-start') {
            $this->type = 'client';
            $client = new Client();
            $client->start();
        }
    }
}