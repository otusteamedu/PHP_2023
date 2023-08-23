<?php

namespace Jasur\App;

use Exception;
use Jasur\App\Socket\ClientSocket;
use Jasur\App\Socket\ServerSocket;

class App
{
    protected $socket;

    protected Server $server;
    protected Client $client;

    public $configs;

    public function __construct()
    {
        $this->configs = parse_ini_file(ROOT . '/html/config/socket.ini', true);
        $this->server = new Server();
        $this->client = new Client();
    }

    public function run(): void
    {

        if (!$type = $_SERVER['argv'][1]) {
            throw new \RuntimeException('Need pass an argument (server/client).');
        }

        switch ($_SERVER['argv'][1]) {
            case 'server':
                $this->socket = new ServerSocket($this->configs['socket']);
                $this->socket->create();
                $this->server->listen($this->socket);
                break;
            case 'client':
                $this->socket = new ClientSocket($this->configs['socket']);
                $this->socket->create();
                $this->client->sendMessage($this->socket);
                break;
        }
    }
}