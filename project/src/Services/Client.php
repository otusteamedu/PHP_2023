<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Vp\App\Config;

class Client implements SocketInterface
{
    public function start()
    {
        error_reporting(E_ALL);

        fwrite(STDOUT, "Соединение через socket" . PHP_EOL);

        $address = Config::getSocketPath();

        fwrite(STDOUT, "Создаем socket" . PHP_EOL);
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($socket === false) {
            $error = "Ошибка. Не удалось создать сокет: " . socket_strerror(socket_last_error());
            fwrite(STDOUT, $error . PHP_EOL);
        }

        fwrite(STDOUT, "Устанавливаем соединение" . PHP_EOL);
        $result = socket_connect($socket, $address, 0);

        if ($result === false) {
            $error = "Ошибка. Не удалось установить соединение: " . socket_strerror(socket_last_error($socket));
            fwrite(STDOUT, $error . PHP_EOL);
        }

        $welcome = "Соединение установлено, можно отправлять сообщения! Чтобы отключиться введите stop.";
        fwrite(STDOUT, $welcome . PHP_EOL . PHP_EOL);

        while (true) {
            $message = stream_get_line(STDIN, 255, PHP_EOL);
            $write = socket_write($socket, $message, strlen($message));

            if (!$write) {
                fwrite(STDOUT, "Ошибка. Сервер закрыл соединение" . PHP_EOL);
                break;
            }

            if (trim($message) === 'stop') {
                break;
            }

            fwrite(STDOUT, PHP_EOL . "Ответ сервера:" . PHP_EOL);
            $out = socket_read($socket, 255);
            fwrite(STDOUT, $out . PHP_EOL);
        }

        fwrite(STDOUT, "Закрываем сокет." . PHP_EOL);
        socket_close($socket);

    }
}
