<?php

declare(strict_types=1);

namespace Atsvetkov\Chat\Handler;

use Lebedevvr\Chat\Socket\Socket;

interface HandlerInterface
{
    public function handle(Socket $socket): void;
}