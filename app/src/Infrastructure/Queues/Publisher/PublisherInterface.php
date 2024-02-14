<?php

declare(strict_types=1);

namespace App\Infrastructure\Queues\Publisher;

interface PublisherInterface
{
    public function publish(string $message): void;
}
