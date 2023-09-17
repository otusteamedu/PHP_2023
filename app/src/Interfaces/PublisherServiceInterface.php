<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Interfaces;

interface PublisherServiceInterface
{
    public function publish(string $messageBody): void;
}
