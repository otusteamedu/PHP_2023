<?php

declare(strict_types=1);

namespace Kanakhin\WebSockets\Infrastructure;

use Kanakhin\WebSockets\Infrastructure\CLI\CliReader;
use Kanakhin\WebSockets\Infrastructure\CLI\CliWriter;
use Kanakhin\WebSockets\Application\SocketClient;
use Kanakhin\WebSockets\Application\SocketServer;

class SocketChat
{
    public function run(array $args): void
    {
        $writer = new CliWriter();
        $reader = new CliReader();

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $task = $args[1];
        if ($task == 'server') {
            if (file_exists($_ENV['SOCKET_HOST'])) {
                unlink($_ENV['SOCKET_HOST']);
            }
            $server = new SocketServer($_ENV['SOCKET_HOST'], (int)$_ENV['IO_BUFFER_SIZE'], (int)$_ENV['MAX_CONNECTIONS'], (int)$_ENV['PORT']);
            $server->start($reader, $writer);
        } elseif ($task == 'client') {
            $client = new SocketClient($_ENV['SOCKET_HOST'], (int)$_ENV['IO_BUFFER_SIZE'], (int)$_ENV['MAX_CONNECTIONS'], (int)$_ENV['PORT']);
            $client->start($reader, $writer);
        } else {
            throw new \Exception('Неверно указаны параметры запуска');
        }
    }
}