<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

abstract class Result
{
    private bool $success;
    private ?string $message;

    public function __construct(bool $success, ?string $message = null)
    {
        $this->success = $success;
        $this->message = $message;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
