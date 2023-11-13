<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase;

use Gesparo\HW\Domain\Repository\ClearEventsInterface;

class ClearEventsUseCase
{
    private ClearEventsInterface $storage;

    public function __construct(ClearEventsInterface $storage)
    {
        $this->storage = $storage;
    }

    public function clear(): void
    {
        $this->storage->clear();
    }
}
