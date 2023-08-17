<?php

declare(strict_types=1);

namespace Otus\SocketChat\SocketChat;

use Otus\SocketChat\Exception\{ReadFromStdinException, WriteToStdoutException};
use Otus\SocketChat\Service\SocketService;
use Otus\SocketChat\Utils\ConfigInterface;
use Socket;

class Client
{
    private ConfigInterface $config;
    private SocketService $socketService;
    private Socket|null $socket = null;

    public function __construct(ConfigInterface $config, SocketService $socketService)
    {
        $this->config = $config;
        $this->socketService = $socketService;
    }

    public function run(): void
    {
        $this->initSocketConnection();

        $this->handleInput();
    }

    private function handleInput(): void
    {
        $this->writeToStdout("Enter message or 'exit' to exit");
        do {
            $input = $this->readFromStdin();
            $this->sendToServer($input);
            $response = $this->socketService->readFromSocket($this->socket);
            $this->writeToStdout($response);
        } while ($input !== 'exit');
        $this->closeConnection($this->config->get('socket_path'));
    }

    private function readFromStdin(): string
    {
        do {
            $input = fgets(STDIN);
            if (false === $input) {
                throw new ReadFromStdinException();
            }
        } while ($input === '');

        return trim($input);
    }

    private function sendToServer(string $input): void
    {
        $this->socketService->writeToSocket($this->socket, $input);
    }

    private function initSocketConnection(): void
    {
        $socketFile = $this->config->get('socket_path');
        $this->socket = $this->socketService->createSocket();
        $this->socketService->connectToSocket($this->socket, $socketFile);
    }

    private function writeToStdout(string $output): void
    {
        $bytes = fwrite(STDOUT, $output . PHP_EOL);
        if (false === $bytes) {
            throw new WriteToStdoutException();
        }
    }

    private function closeConnection(string $socketFile): void
    {
        if ($this->socket) {
            socket_close($this->socket);
        }

        if (file_exists($socketFile)) {
            unlink($socketFile);
        }
        $this->writeToStdout('Connection was closed');
    }
}