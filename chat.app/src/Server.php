<?php

declare(strict_types= 1);

namespace Dshevchenko\Brownchat;

use Dshevchenko\Brownchat\SocketServer;

class Server
{
    private const EXIT = '/exit';
    private const STOP_SERVER = '/stopserver';

    private SocketServer $socket;

    public function __construct(array $settings)
    {
        $this->socket = new SocketServer($settings);
    }

    public function run(): void
    {
        $this->socket->create();
       
        $isRunning = true;

        while ($isRunning) {
            fwrite(STDOUT, 'Waiting for client... ');
            if ($this->socket->accept()) {
                fwrite(STDOUT, "CLIENT CONNECTED\n");
            } else {
                return;
            }

            $isReading = true;

            while ($isRunning && $isReading) {
                $buffer = $this->socket->read();

                if ($buffer === '' || $buffer === self::EXIT) {
                    fwrite(STDOUT, "Client is disconnected\n");
                    $this->socket->drop();
                    $isReading = false;
                }
                elseif ($buffer === self::STOP_SERVER) {
                    fwrite(STDOUT, "Server stopped by client\n");
                    $isRunning = false;
                } 
                else {
                    fwrite(STDOUT, ">>> $buffer\n");
                    $this->socket->write('Received ' . (string)strlen($buffer) . ' bytes');
                }
            }
        }
    }
}
