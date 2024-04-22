<?php

namespace Anna\Chat;

use Exception;

class App
{
    private array $sockets;

    public function __construct()
    {
        $this->sockets = [
            'server' => new ServerSocket(),
            'client' => new ClientSocket()
        ];
    }

    /**
     * @throws Exception
     */
    public function run(): iterable
    {
        if (!isset($_SERVER['argv'][1])) {
            throw new Exception('Empty command.');
        }
        $socket = $_SERVER['argv'][1];
        if (!isset($this->sockets[$socket])) {
            throw new Exception('Unknown command.');
        }
        return $this->setSocket($socket)->run();
    }

    private function setSocket($socket): Socket
    {
        return new $this->sockets[$socket]();
    }
}
