<?php

namespace App;

use Exception;
use Socket;


class App
{
    /** @var string  */
    protected const SERVER = 'server';

    /** @var string  */
    protected const CLIENT  = 'client';

    /** @var string  */
    protected const EXIT = 'выход';

    /** @var string  */
    protected const SHUTDOWN = 'выключение';

    /** @var string */
    protected string $mode;

    /** @var array */
    protected array $config;


    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->mode = $_SERVER['argv'][1] ?? null;
        $this->config = parse_ini_string(file_get_contents(__DIR__ . '/../app.conf'));
    }

    public function __destruct()
    {
        if (
            $this->mode == static::SERVER
            && isset($this->config['unix_socket'])
            && file_exists($this->config['unix_socket'])
        ) {
            unlink($this->config['unix_socket']);
        }
    }

    /**
     * @return void
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
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @return Socket
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
     * @param Socket $socket
     * @param string $address
     * @param int $port
     * @return bool
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
     * @param Socket $socket
     * @return bool
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
     * @param Socket $socket
     * @return Socket
     * @throws Exception
     */
    protected function socketAccept(Socket $socket): Socket
    {
        if (($messageSocket = socket_accept($socket)) === false) {
            throw new Exception(socket_strerror(socket_last_error($socket)));
        }

        return $messageSocket;
    }

    /**
     * @param Socket $socket
     * @param string $message
     * @param int $length
     * @return false|int
     */
    protected function socketWrite(Socket $socket, string $message, int $length): bool|int
    {
        return socket_write($socket, $message, $length);
    }

    /**
     * @param Socket $socket
     * @param int $length
     * @param int $mode
     * @return false|string
     */
    protected function socketRead(Socket $socket, int $length, int $mode = PHP_BINARY_READ): bool|string
    {
        return socket_read($socket, $length, $mode);
    }

    /**
     * @param Socket $socket
     * @return void
     */
    protected function socketClose(Socket $socket): void
    {
        socket_close($socket);
    }

    /**
     * @param Socket $socket
     * @param string $address
     * @param int|null $port
     * @return bool
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
     * @return void
     * @throws Exception
     */
    protected function runServer(): void
    {
        $socket = $this->createSocket();
        $this->socketBind($socket, $this->config['unix_socket']);
        $this->socketListen($socket);

        do {
            $messageSocket = $this->socketAccept($socket);

            // Отправляем инструкции
            $msg = PHP_EOL . "Добро пожаловать на тестовый сервер PHP." . PHP_EOL .
                "Чтобы отключиться, наберите 'выход'. Чтобы выключить сервер, наберите 'выключение'." . PHP_EOL;
            $this->socketWrite($messageSocket, $msg, 2048);

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

                $receivedBytes = mb_strlen($receivedMessage);
                $talkback = "Received {$receivedBytes} bytes" . PHP_EOL;
                echo $receivedMessage . PHP_EOL;
                $this->socketWrite($messageSocket, $talkback, 2048);
            } while (true);
            $this->socketClose($messageSocket);
        } while (true);
        $this->socketClose($socket);
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function runClient(): void
    {
        $socket = $this->createSocket();
        $this->socketConnect($socket, $this->config['unix_socket']);

        do {
            echo $this->socketRead($socket, 2048);

            // Читаем одну строку из STDIN
            do {
                $line = rtrim(fgets(STDIN), PHP_EOL);
            } while (!($line));

            $this->socketWrite($socket, $line, 2048);

            if ($line == static::EXIT || $line == static::SHUTDOWN) {
                $this->socketClose($socket);
                break;
            }
        } while (true);
    }
}
