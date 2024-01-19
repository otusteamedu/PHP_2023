<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Application;

use Kanakhin\WebSockets\Domain\ISocketReader;
use Kanakhin\WebSockets\Domain\ISocketWriter;
use Kanakhin\WebSockets\Domain\SocketEntity;

class SocketClient extends SocketEntity
{
    public function __construct(string $socket_host, int $io_buffer_size, int $max_connections, int $port)
    {
        parent::__construct($socket_host, $io_buffer_size, $max_connections, $port);
        $this->create();
        $this->connect();
    }

    public function start(ISocketReader $reader, ISocketWriter $writer): void {
        while (true) {
            $message = $reader->readLine();

            $this->write($message);

            if ($message === '/stop') {
                break;
            }

            $writer->write($this->read());
        }

        $this->close();
    }
}