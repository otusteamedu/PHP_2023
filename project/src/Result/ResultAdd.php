<?php

declare(strict_types=1);

namespace Vp\App\Result;

class ResultAdd
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

    public function __toString()
    {
        return $this->message;
    }
}
