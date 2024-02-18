<?php

namespace App\Domains\Order\Domain\ValueObjects;

class Status
{
    private string $status;
    public function __construct(string $status)
    {
        $this->assertValidStatus($status);
        $this->status = $status;
    }

    public function getValue(): string
    {
        return $this->status;
    }

    private function assertValidStatus(string $status): void
    {
        if (!in_array($status, ['created', 'in_process', 'complete'])) {
            throw new \InvalidArgumentException('Статус не валидный');
        }
    }
}
