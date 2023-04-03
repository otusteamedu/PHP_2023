<?php

declare(strict_types=1);

namespace Imitronov\Hw7\UseCase\SocketClient;

final class CreateSocketClientInput
{
    public function __construct(
        private string $host,
        private \Closure $messageReader,
        private \Closure $messageHandler,
    ) {
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getMessageReader(): \Closure
    {
        return $this->messageReader;
    }

    public function getMessageHandler(): \Closure
    {
        return $this->messageHandler;
    }
}
