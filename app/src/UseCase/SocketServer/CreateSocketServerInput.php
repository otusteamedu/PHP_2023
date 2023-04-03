<?php

declare(strict_types=1);

namespace Imitronov\Hw7\UseCase\SocketServer;

final class CreateSocketServerInput
{
    public function __construct(
        private string $host,
        private int $backlog,
        private \Closure $messageHandler,
    ) {
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getBacklog(): int
    {
        return $this->backlog;
    }

    public function getMessageHandler(): \Closure
    {
        return $this->messageHandler;
    }
}
