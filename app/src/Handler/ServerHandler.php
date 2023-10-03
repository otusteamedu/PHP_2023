<?php

declare(strict_types=1);

namespace Lebedevvr\Chat\Handler;

use Lebedevvr\Chat\Socket\Socket;

class ServerHandler implements HandlerInterface
{
    public function handle(Socket $socket): void
    {
        $socket->create(true);
        $socket->bind();
        $socket->listen();

        echo 'Server start listening' . PHP_EOL;
        $clientSocket = $socket->accept();
        while (true) {
            $data = $socket->receive($clientSocket);
            echo $data . PHP_EOL;
            $answer = 'Received: ' . mb_strlen($data) . PHP_EOL;
            $socket->write($answer, $clientSocket);
            echo $answer;
        }
    }
}
