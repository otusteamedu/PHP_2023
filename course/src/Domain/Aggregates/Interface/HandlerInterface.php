<?php

namespace Cases\Php2023\Domain\Aggregates\Interface;

interface HandlerInterface
{
    public function setNext(HandlerInterface $handler): HandlerInterface;
    public function handle(): ?string;
}
