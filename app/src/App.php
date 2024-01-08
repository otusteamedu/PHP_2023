<?php

namespace Builov\Chat;

use Exception;

class App
{
    private $mode;
    private $mode_options = [
        'server',
        'client'
    ];

    public function __construct()
    {
        global $argv;

        if (!array_key_exists(1, $argv) || !in_array($argv[1], $this->mode_options)) {
            throw new Exception('Некорректный аргумент. Укажите \'server\' или \'client\' в качестве первого аргумента.');
        }

        $this->mode = $argv[1];
    }

    public function run(): void
    {
        if ($this->mode == 'server') {
            $this->runServer();
        } elseif ($this->mode == 'client') {
            $this->runClient();
        }
    }

    private function runServer()
    {
        $server = new Server();
        $server->run();
    }

    private function runClient()
    {
        $client = new Client();
        $client->run();
    }

}