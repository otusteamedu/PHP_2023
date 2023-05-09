<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

class ResultInit
{
    private bool $success;
    private string $message;

    public function __construct(bool $success, string $message)
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
