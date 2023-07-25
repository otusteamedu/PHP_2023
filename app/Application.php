<?php

namespace app;

use App\Services\Socket\ClientSocket;
use App\Services\Socket\ServerSocket;
use RuntimeException;

class Application
{
    public array|false $config;

    public function __construct()
    {
        $this->config = parse_ini_file('config/socket.ini', true);

        if ($this->config === false) {
            throw new RuntimeException('Config file not found');
        }

        $this->putToEnvironments();
    }

    public function run(): void
    {
        if (! $type = $_SERVER['argv'][1]) {
            throw new RuntimeException('Write type: server or client');
        }

        match ($type) {
            'server' => (new ServerSocket())->handle(),
            'client' => (new ClientSocket())->handle(),
            default => throw new RuntimeException('Wrong type'),
        };

    }

    private function putToEnvironments(): void
    {
        foreach ($this->config as $key => $value) {
            putenv("$key=$value");
        }
    }
}
