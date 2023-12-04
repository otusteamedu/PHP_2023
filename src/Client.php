<?php

declare(strict_types=1);

namespace App;

class Client
{
    public function handle(ChatSocket $socket): void
    {
        $socket->create();
        $socket->connect();

        echo "Добровать пожаловать в консольный чат. Введите сообщение и нажмите ENTER. Для выхода из чата введите 'exit' и нажмите ENTER" . PHP_EOL;

        while (true) {
            echo 'Введите сообщение: ';
            $input = readline();
            $socket->send($input);

            echo 'Сервер получил ' . $socket->read() . ' bytes.' . PHP_EOL;

            if ($input === 'exit') {
                break;
            }
        }
    }
}
