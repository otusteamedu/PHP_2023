<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Request;

class SendMessageRequest
{
    public function __construct(
        public ?string $accountNumber = null,
        public ?string $startDate = null,
        public ?string $endDate = null)
    {
    }
}
