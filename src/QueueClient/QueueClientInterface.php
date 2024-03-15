<?php

declare(strict_types=1);

namespace App\QueueClient;

interface QueueClientInterface
{
    public function consume(): void;

    public function publish(string $message): void;

    public function close(): void;
}
