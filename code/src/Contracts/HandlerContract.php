<?php

declare(strict_types=1);

namespace EEvstifeev\Chat\Contracts;

use EEvstifeev\Chat\Socket;

interface HandlerContract
{
    public function handle(Socket $socket): void;
}
