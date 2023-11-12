<?php

namespace User\Php2023\Domain\Interfaces;

interface QueueConsumeHandlerInterface
{
    public function handle($message): void;
}
