<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class App
{
    private string $mode;
    private Socket $socket;

    public function __construct($argv, $argc)
    {
        if ($argc < 2) {
            throw new InvalidArgumentException('Usage: php app.php server|client');
        }

        $mode = $argv[1];

        switch ($mode) {
            case 'server':
                $this->mode = 'server';
                break;
            case 'client':
                $this->mode = 'client';
                break;
            default:
                throw new InvalidArgumentException('Invalid mode. Use "server" or "client".');
        }
    }

    public function run()
    {
        $config = parse_ini_file('/../config/config.ini', true);
        $file = $config['socket']['file'];

        $this->socket = new Socket($file);

        switch ($this->mode) {
            case 'server':
                $server = new Server($this->socket);
                $server->start();
                break;
            case 'client':
                $client = new Client($this->socket);
                $client->start();
                break;
        }
    }
}
