<?php

declare(strict_types=1);

namespace Lebedevvr\Chat\Handler;

use Lebedevvr\Chat\Socket\Socket;

class ServerHandler implements HandlerInterface
{

    public function handle(Socket $socket): void
    {
        $socket->create();
        $socket->bind();

    }
}
