<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

class Client
{
    private const EXIT = '/exit';
    private const STOP_SERVER = '/stopserver';

    private SocketClient $socket;

    public function __construct()
    {   
        $settings = new Settings();
        $this->socket = new SocketClient($settings);
    }

    public function run(): void
    {
        Console::write('Welcome to BrownChat Client!');

        $isRunning = $this->connectToServer();

        while ($isRunning) {
            $message = Console::read('>>> ');
            if ($message !== '') {
                $result = $this->sendMessage($message);
                $isRunning = $this->isClientRunning($message, $result);
                if ($result !== '') {
                    Console::write("\e[90mSRV $result\e[0m\n");
                }
            }
        }

        $this->disconnect();
    }

    private function connectToServer(): bool
    {
        Console::write('Connecting to server... ', false);
        if ($this->socket->connect()) {
            Console::write('SUCCESS');
        } else {
            Console::write('FAIL');
            return false;
        }
        return true;
    }

    private function disconnect(): bool
    {
        Console::write('Disconnecting... ', false);
        try {
            $this->socket->close(); 
            Console::write('SUCCESS');
        } catch (\Exception $e) {
            Console::write('FAIL');
            Console::write($e->getMessage());
            return false;
        }
        return true;
    }

    private function sendMessage(string $message): string
    {
        $this->socket->write($message);
        $confirmation = $this->socket->read();
        return $confirmation;
    }

    private function isClientRunning(string $message, string $result): bool
    {
        $running = ($result !== '') 
            && $message !== self::EXIT
            && $message !== self::STOP_SERVER;

        return $running;
    }
}
