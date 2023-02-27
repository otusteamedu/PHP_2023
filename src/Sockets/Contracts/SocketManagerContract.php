<?php

declare(strict_types=1);

namespace Twent\Chat\Sockets\Contracts;

use Socket;

interface SocketManagerContract extends SocketClientContract
{
    public function __construct();
    public function select(array &$read): ?int;
    public function accept(): ?Socket;
    public function close(?Socket $socket = null): void;
}
