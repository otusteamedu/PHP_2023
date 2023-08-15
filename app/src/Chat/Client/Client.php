<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\Chat\Client;

use DmitryEsaulenko\Hw15\Constants;
use Socket\Raw\Socket;

class Client implements ClientInterface
{
    private Socket $socket;

    public function __construct(
        Socket $socket
    ) {
        $this->socket = $socket;
    }

    public function run(): void
    {
        while (($line = fgets(STDIN)) !== false) {
            $this->socket->write($line);
            $data = $this->socket->read(Constants::MESSAGE_LENGTH);
            if (!$data) {
                continue;
            }
            fwrite(STDOUT, $data);
        }
    }
}
