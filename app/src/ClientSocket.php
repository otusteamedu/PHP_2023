<?php

declare(strict_types=1);

namespace Agrechuha\Otus;

class ClientSocket extends Socket
{
    /**
     * @return void
     */
    public function connectToChat(): void
    {
        $this->initSocket();

        while (true) {
            echo 'Введите сообщение и нажмите Enter: ' . PHP_EOL;

            $message = readline();
            $this->write($message);

            if ($message === '/exit') {
                break;
            }
        }

        $this->close();
    }

    /**
     * @return void
     */
    public function initSocket(): void
    {
        $this->create(false);
        $this->connect();
    }
}
