<?php

declare(strict_types=1);

namespace Atsvetkov\Chat\Handler;

use Atsvetkov\Chat\Socket\Socket;

interface HandlerInterface
{
    public function handle(Socket $socket): void;
}