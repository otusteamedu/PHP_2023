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

    /**
     * @throws Exception
     */
    public function __construct()
    {
        global $argv;

        if (!array_key_exists(1, $argv) || !in_array($argv[1], $this->mode_options)) {
            throw new Exception('Некорректный аргумент. Укажите \'server\' или \'client\' в качестве первого аргумента.');
        }

        $this->mode = $argv[1];
    }

    public function run(): iterable
    {
        if ($this->mode == 'server') {
            foreach ($this->runServer() as $message) {
                yield $message;
            }
        } elseif ($this->mode == 'client') {
            foreach ($this->runClient() as $message) {
                yield $message;
            }
        }
    }

    private function runServer(): iterable
    {
        $server = new Server();
        foreach ($server->run() as $message) {
            yield $message;
        }
    }

    private function runClient(): iterable
    {
        $client = new Client();
        foreach ($client->run() as $message) {
            yield $message;
        }
    }
}
