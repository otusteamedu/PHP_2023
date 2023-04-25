<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

use Illuminate\Database\Eloquent\Collection;

class ResultGet
{
    private bool $success;
    private ?string $message;
    private ?Collection $result;

    public function __construct(bool $success, string $message = null, ?Collection $result = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->result = $result;
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
