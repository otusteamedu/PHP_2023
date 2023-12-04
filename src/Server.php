<?php

declare(strict_types=1);

namespace App;

class Server
{
    public function handle(ChatSocket $socket): void
    {
        $socket->create();
        $socket->bind();
        $socket->listen();

        echo 'Ожидаю подключение клиента...' . PHP_EOL;
        $clientSocket = $socket->accept();
        echo 'Клиент подключен' . PHP_EOL;

        while (true) {
            echo 'Ожидаю получение сообщения...' . PHP_EOL;

            [$data, $bytes_received] = $socket->receive($clientSocket);
            echo 'Получено сообщение: ' . $data . PHP_EOL;
            $socket->send($bytes_received, $clientSocket);

            if ($data == 'exit') {
                echo "До свидания!";
                break;
            }
        }
    }
}
