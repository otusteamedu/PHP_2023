<?php

namespace App\Infrastructure;

interface MessageQueueRepositoryInterface
{
    public function add(string $message): void;
    public function clear(): void;
    public function read(): void;

    public function getConfig(): GetterInterface;
}
