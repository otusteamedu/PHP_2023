<?php

namespace Cases\Php2023\Domain\Aggregates\Abstract;

use Cases\Php2023\Domain\Aggregates\Interface\HandlerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    private ?HandlerInterface $nextHandler;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(): ?string
    {
        return $this->nextHandler?->handle();
    }
}