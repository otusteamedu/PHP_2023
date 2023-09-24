<?php

declare(strict_types=1);

namespace Eevstifeev\Chat\Handlers;

use Eevstifeev\Chat\Contracts\SocketContract;

final class ClientSocket extends MainSocket implements SocketContract
{
    public function handle(): void
    {
        $this->initSocket();
        while (true) {
            echo 'Сообщение: ';
            $input = readline();
            $this->writeSocket($input);
            echo 'The server received ' .$this->readSocket() . ' bytes.' . PHP_EOL;
        }
    }
    private function initSocket(): void
    {
        $this->createSocket();
        $this->connectSocket();
    }
}
