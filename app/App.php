<?php

namespace App;

use Exception;


class App
{
    /** @var string  */
    protected const SERVER = 'server';

    /** @var string  */
    protected const CLIENT  = 'client';

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
     * @return void
     * @throws Exception
     */
    protected function runServer(): void
    {
        if (($sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new Exception(socket_strerror(socket_last_error()));
        }

        if (socket_bind($sock, $this->config['unix_socket']) === false) {
            throw new Exception(socket_strerror(socket_last_error($sock)));
        }

        if (socket_listen($sock) === false) {
            throw new Exception(socket_strerror(socket_last_error($sock)));
        }

        do {
            if (($msgSock = socket_accept($sock)) === false) {
                throw new Exception(socket_strerror(socket_last_error($sock)));
            }

            // Отправляем инструкции
            $msg = PHP_EOL . "Добро пожаловать на тестовый сервер PHP." . PHP_EOL .
                "Чтобы отключиться, наберите 'выход'. Чтобы выключить сервер, наберите 'выключение'." . PHP_EOL;
            socket_write($msgSock, $msg, 2048);

            do {
                if (false === ($buf = socket_read($msgSock, 2048))) {
                    echo socket_strerror(socket_last_error($msgSock)) . PHP_EOL;
                    break 2;
                }

                if ($buf == 'выход') {
                    break;
                }

                if ($buf == 'выключение') {
                    socket_close($msgSock);
                    break 2;
                }

                $receivedBytes = mb_strlen($buf);
                $talkback = "Received {$receivedBytes} bytes" . PHP_EOL;
                echo $buf . PHP_EOL;
                socket_write($msgSock, $talkback, 2048);
            } while (true);
            socket_close($msgSock);
        } while (true);
        socket_close($sock);
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function runClient(): void
    {
        if (($sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new Exception(socket_strerror(socket_last_error()));
        }

        $result = socket_connect($sock, $this->config['unix_socket']);

        if ($result === false) {
            throw new Exception(socket_strerror(socket_last_error($sock)));
        }

        do {
            echo socket_read($sock, 2048);

            // Читаем одну строку из STDIN
            do {
                $line = rtrim(fgets(STDIN), PHP_EOL);
            } while (!($line));

            socket_write($sock, $line, 2048);

            if ($line == 'выход' || $line == 'выключение') {
                socket_close($sock);
                break;
            }
        } while (true);
    }
}
