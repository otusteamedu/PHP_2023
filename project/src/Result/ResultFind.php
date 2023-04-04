<?php

declare(strict_types=1);

namespace Vp\App\Result;

use WS\Utils\Collections\Collection;

class ResultFind
{
    private bool $success;
    private ?string $message;
    private ?Collection $result;

    public function __construct(bool $success, ?string $message = null, Collection $collection = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->result = $collection;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getResult(): ?Collection
    {
        return $this->result;
    }

    public function __toString()
    {
        return $this->message;
    }
}
