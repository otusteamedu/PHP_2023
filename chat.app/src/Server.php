<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

use Dshevchenko\Brownchat\SocketServer;

class Server
{
    private const EXIT = '/exit';
    private const STOP_SERVER = '/stopserver';

    private SocketServer $socket;

    public function __construct()
    {
        $settings = new Settings();
        $this->socket = new SocketServer($settings);
    }

    public function run(): void
    {
        Console::write('Welcome to BrownChat Server!');

        $isRunning = $this->createSocket();

        while ($isRunning) {
            $isReading = $this->acceptClient();
            $isRunning = $isReading;

            while ($isRunning && $isReading) {
                $message = $this->readFromClient();
                $isReading = !$this->isClientDisconnected($message);
                $isRunning = !$this->isServerStopped($message);
                if ($isRunning && $isReading) {
                    Console::write('>>> ' . $message);
                    $this->confirmReading($message);
                } elseif (!$isReading) {
                    $this->dropClient();
                }
            }
        }
    }

    private function createSocket(): bool
    {
        Console::write('Creating socket... ', false);
        try {
            $this->socket->create();
            Console::write('SUCCESS');
            return true;
        } catch (\Exception $e) {
            Console::write('FAIL');
            return false;
        }
    }

    private function acceptClient(): bool
    {
        Console::write('Waiting for client... ', false);
        if ($this->socket->accept()) {
            Console::write('CONNECTED');
            return true;
        } else {
            return false;
        }
    }

    private function dropClient(): void
    {
        $this->socket->drop();
    }

    private function readFromClient(): string
    {
        $incomingMsg = $this->socket->read();
        return $incomingMsg;
    }

    private function confirmReading(string $message): void
    {
        $messageLen = strlen($message);
        $this->socket->write('Received ' . (string)$messageLen . ' bytes');
    }

    private function isClientDisconnected(string $message): bool
    {
        $disconnected = ($message === self::EXIT) || ($message === '');
        if ($disconnected) {
            Console::write('Client is disconnected');
        }
        return $disconnected;
    }

    private function isServerStopped(string $message): bool
    {
        if ($message === self::STOP_SERVER) {
            Console::write('Server stopped by client');
            return true;
        }
        return false;
    }
}
