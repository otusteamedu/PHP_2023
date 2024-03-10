<?php

namespace App\Infrastructure\Queues\Publisher;

interface PublisherInterface
{
    public function publish(string $message): void;
}
