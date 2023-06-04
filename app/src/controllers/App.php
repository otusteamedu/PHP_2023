<?php

declare(strict_types=1);

namespace nikitaglobal\controllers;

use nikitaglobal\controllers\client\Client as Client;
use nikitaglobal\controllers\server\Server as Server;
use nikitaglobal\controllers\client\Socket as SocketClient;
use nikitaglobal\controllers\server\Socket as SocketServer;

class App
{
    protected SocketServer|SocketClient $socket;

    protected Server $server;

    protected Client $client;

    public array|bool $configs;

    public function __construct()
    {
        $this->configs = parse_ini_file('config.ini', true);
        $this->server = new Server();
        $this->client = new Client();
    }

    public function run(): void
    {
        if (!$type = $_SERVER['argv'][1]) {
            throw new \RuntimeException('Need pass an argument (server/client).');
        }
        switch ($type) {
            case 'server':
                $this->socket = new SocketServer($this->configs['socket']);
                $this->socket->create();
                $this->server->listen($this->socket);
                break;
            case 'client':
                $this->socket = new SocketClient($this->configs['socket']);
                $this->socket->create();
                $this->client->sendMessage($this->socket);
                break;
        }
    }
}
