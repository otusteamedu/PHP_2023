<?php

namespace App;

use Exception;
use Socket;

class App
{
    protected const SERVER = 'server';
    protected const CLIENT  = 'client';
    protected const EXIT = 'выход';
    protected const SHUTDOWN = 'выключение';

    protected string $mode;
    protected string $fileSocket;

    protected array $config;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->mode = $_SERVER['argv'][1] ?? null;
        $this->config = parse_ini_string(file_get_contents(__DIR__ . '/../app.conf'));
        $this->fileSocket = $this->config['unix_socket'] ?? null;
    }

    public function __destruct()
    {
        if (
            $this->mode == static::SERVER
            && $this->fileSocket
            && file_exists($this->fileSocket)
        ) {
            unlink($this->fileSocket);
        }
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        switch ($this->mode) {
            case static::SERVER:
                $this->runServer();
                break;
            case static::CLIENT:
                $this->runClient();
                break;
            default:
                throw new Exception(
                    'The application must be started with one of the arguments: ' . PHP_EOL
                    . static::SERVER . PHP_EOL
                    . static::CLIENT . PHP_EOL
                );
        }
    }

    /**
     * @throws Exception
     */
    protected function createSocket(int $domain = AF_UNIX, int $type = SOCK_STREAM, int $protocol = 0): Socket
    {
        if (($socket = socket_create($domain, $type, $protocol)) === false) {
            throw new Exception(socket_strerror(socket_last_error()));
        }

        return $socket;
    }

    /**
     * @throws Exception
     */
    protected function socketBind(Socket $socket, string $address, int $port = 0): bool
    {
        if (($result = socket_bind($socket, $address, $port)) === false) {
            throw new Exception(socket_strerror(socket_last_error($socket)));
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    protected function socketListen(Socket $socket): bool
    {
        if (($result = socket_listen($socket)) === false) {
            throw new Exception(socket_strerror(socket_last_error($socket)));
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    protected function socketAccept(Socket $socket): Socket
    {
        if (($messageSocket = socket_accept($socket)) === false) {
            throw new Exception(socket_strerror(socket_last_error($socket)));
        }

        return $messageSocket;
    }

    protected function socketWrite(Socket $socket, string $message, int $length): bool|int
    {
        return socket_write($socket, $message, $length);
    }

    protected function socketRead(Socket $socket, int $length, int $mode = PHP_BINARY_READ): bool|string
    {
        return socket_read($socket, $length, $mode);
    }

    protected function socketClose(Socket $socket): void
    {
        socket_close($socket);
    }

    /**
     * @throws Exception
     */
    protected function socketConnect(Socket $socket, string $address, ?int $port = null): bool
    {
        if (($result = socket_connect($socket, $address, $port)) === false) {
            throw new Exception(socket_strerror(socket_last_error($socket)));
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    protected function runServer(): void
    {
        $socket = $this->createSocket();
        $this->socketBind($socket, $this->fileSocket);
        $this->socketListen($socket);

        do {
            $messageSocket = $this->socketAccept($socket);

            do {
                if (false === ($receivedMessage = $this->socketRead($messageSocket, 2048))) {
                    break 2;
                }

                if ($receivedMessage == static::EXIT) {
                    break;
                }

                if ($receivedMessage == static::SHUTDOWN) {
                    $this->socketClose($messageSocket);
                    break 2;
                }

                echo 'Message from client: ' . $receivedMessage . PHP_EOL;

                $this->socketWrite($messageSocket, $receivedMessage, 2048);
            } while (true);

            $this->socketClose($messageSocket);
        } while (true);
        $this->socketClose($socket);
    }

    /**
     * @throws Exception
     */
    protected function runClient(): void
    {
        $socket = $this->createSocket();
        $this->socketConnect($socket, $this->fileSocket);

        do {
            do {
                $line = rtrim(fgets(STDIN), PHP_EOL);
            } while (!($line));

            $this->socketWrite($socket, $line, 2048);

            if ($line == static::EXIT || $line == static::SHUTDOWN) {
                $this->socketClose($socket);
                break;
            }

            if (false === ($receivedMessage = $this->socketRead($socket, 2048))) {
                break;
            }

            echo 'Answer from server: ' . $receivedMessage . PHP_EOL;
        } while (true);
    }
}
