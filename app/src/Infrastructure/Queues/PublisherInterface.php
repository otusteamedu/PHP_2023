<?php

namespace App\Infrastructure\Queues;

interface PublisherInterface
{
    public function publish(string $message): void;
}
