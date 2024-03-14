<?php

declare(strict_types=1);

namespace App\Rabbit\Interfaces;

interface PublisherInterface
{
    public function publish(string $message): void;
}
