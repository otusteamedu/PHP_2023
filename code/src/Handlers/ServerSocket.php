<?php

declare(strict_types=1);

namespace Eevstifeev\Chat\Handlers;

use Eevstifeev\Chat\Contracts\SocketContract;

final class ServerSocket extends MainSocket implements SocketContract
{
    public function handle(): void
    {
        $this->initSocket();

        echo 'Server started'. PHP_EOL;
        while (true) {
            $this->createChat();
        }
    }
    private function createChat()
    {
        $clientSocket = $this->acceptSocket();
        while (true) {
            $data = $this->receiveFromSocket($clientSocket);
            echo $data . PHP_EOL;
            $answer = 'Received: '. mb_strlen($data) . PHP_EOL;
            $this->writeSocket($answer, $clientSocket);
            echo $answer;
        }
    }
    private function initSocket(): void
    {
        $this->createSocket(true);
        $this->bindSocket();
        $this->listenSocket();
    }

}