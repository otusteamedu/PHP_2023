<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\Chat\Server;

use DmitryEsaulenko\Hw15\Constants;
use Socket\Raw\Socket;

class ServerSocket implements ServerInterface
{
    private Socket $socket;

    public function __construct(
        Socket $socket
    ) {
        $this->socket = $socket;
    }

    public function run(): void
    {
        $socket = $this->socket->accept();
        while (true) {
            $data = $socket->read(Constants::MESSAGE_LENGTH);
            fwrite(STDOUT, $data);
            $answer = $this->prepareAnswer($data);
            $socket->write($answer);
        }
    }

    public function prepareAnswer(string $data): string
    {
        $messageLength = mb_strlen($data);
        return "Received $messageLength bytes"  . PHP_EOL;
    }
}
