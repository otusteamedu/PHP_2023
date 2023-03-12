<?php

namespace Vp\App\DTO;

class InitResult
{
    private bool $success;
    private ?string $error;
    private ?\Socket $socket;

    public function __construct(bool $success, ?string $error, ?\Socket $socket = null)
    {
        $this->success = $success;
        $this->error = $error;
        $this->socket = $socket;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getSocket(): ?\Socket
    {
        return $this->socket;
    }
}
