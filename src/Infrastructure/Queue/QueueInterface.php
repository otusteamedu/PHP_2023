<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Queue;

interface QueueInterface
{
    public function push(array $data): void;

    public function get(): array;
}
