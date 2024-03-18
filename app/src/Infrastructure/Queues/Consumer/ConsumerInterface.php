<?php

namespace App\Infrastructure\Queues\Consumer;

interface ConsumerInterface
{
    public function run(): void;
}
