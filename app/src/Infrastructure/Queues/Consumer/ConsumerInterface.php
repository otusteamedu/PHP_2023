<?php

declare(strict_types=1);

namespace App\Infrastructure\Queues\Consumer;

interface ConsumerInterface
{
    public function run(): void;
}
