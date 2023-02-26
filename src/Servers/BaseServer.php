<?php

declare(strict_types=1);

namespace Twent\Chat\Servers;

use Socket;
use Twent\Chat\Servers\Contracts\ServerContract;
use Twent\Chat\Sockets\BaseSocketClient;
use Twent\Chat\Sockets\BaseSocketManager;
use Twent\Chat\Sockets\Contracts\SocketClientContract;

abstract class BaseServer implements ServerContract
{
    protected readonly ?SocketClientContract $client;
    protected static ?ServerContract $instance = null;
    protected ?Socket $socket;

    public function __construct(
        protected readonly BaseSocketManager|BaseSocketClient $socketManager,
    ) {
        $this->socket = $this->socketManager->getSocket();
    }

    final public function __clone(): void
    {
    }

    final public function __wakeup(): void
    {
    }

    abstract public static function getInstance(): ?ServerContract;
}
