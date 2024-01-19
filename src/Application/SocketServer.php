<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Application;

use Kanakhin\WebSockets\Domain\ISocketReader;
use Kanakhin\WebSockets\Domain\ISocketWriter;
use Kanakhin\WebSockets\Domain\SocketEntity;

class SocketServer extends SocketEntity
{
    public function __construct(string $socket_host, int $io_buffer_size, int $max_connections, int $port)
    {
        parent::__construct($socket_host, $io_buffer_size, $max_connections, $port);
        $this->create();
        $this->bind();
        $this->listen();
    }
    public function start(ISocketReader $reader, ISocketWriter $writer): void {
        $writer->write('Ожидание подключений... ');
        $connection = $this->accept();
        while (true) {
            $message = $this->read($connection);
            if ($message === '/stop') {
                break;
            }

            if ($message) {
                $writer->write('Сообщение: ' . $message);
            }
            $this->write('Получено сообщение ' . strlen($message) . ' симв.', $connection);
        }
        $this->close();
    }
}