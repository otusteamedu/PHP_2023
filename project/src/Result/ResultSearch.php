<?php

declare(strict_types=1);

namespace Vp\App\Result;

class ResultSearch
{
    private bool $success;
    private ?string $message;
    private ?array $result;

    public function __construct(bool $success, ?string $message = null, ?array $result = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->result = $result;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function __toString()
    {
        return $this->message;
    }
}
