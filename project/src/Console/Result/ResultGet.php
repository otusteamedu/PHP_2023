<?php

declare(strict_types=1);

namespace Vp\App\Console\Result;

use LucidFrame\Console\ConsoleTable;

class ResultGet
{
    private bool $success;
    private ?string $message;
    private ?ConsoleTable $result;

    public function __construct(bool $success, string $message = null, ConsoleTable $result = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->result = $result;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function show(): void
    {
        if ($this->result == null) {
            return;
        }
        $this->result->display();
    }
}
