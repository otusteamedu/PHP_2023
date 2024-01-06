<?php

namespace App\Infrastructure;

interface QueueRepositoryInterface
{
    public function add(string $message): void;
    public function clear(): void;
    public function readMessagesAndNotify(string $par = ''): void;
}
