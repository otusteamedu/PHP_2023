<?php

declare(strict_types=1);

namespace Gesparo\Homework\Command;

use Gesparo\Homework\Service\ReceiveMessageService;

class ReceiveMessageCommand
{
    public function __construct(
        private readonly ReceiveMessageService $receiveMessageService
    )
    {
    }

    public function execute(): void
    {
        $this->receiveMessageService->receive();
    }
}