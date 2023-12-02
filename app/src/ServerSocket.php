<?php

declare(strict_types=1);

namespace Agrechuha\Otus;

class ServerSocket extends Socket
{
    /**
     * @return void
     */
    public function createChatServer(): void
    {
        $this->initSocket();

        echo 'В ожидании сообщения от клиента...' . PHP_EOL;

        $client = $this->accept();

        while (true) {
            $message = $this->receive($client);

            if ($message === '/exit') {
                socket_close($client);

                break;
            }

            if ($message) {
                echo $message . PHP_EOL;

                $this->write($message, $client);
            }
        }

        $this->close();
    }

    /**
     * @return void
     */
    public function initSocket(): void
    {
        $this->create();
        $this->bind();
        $this->listen();
    }
}
