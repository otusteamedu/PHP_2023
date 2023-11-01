<?php

declare(strict_types=1);

namespace Gesparo\HW\Service;

use Gesparo\HW\Storage\ClearInterface;

class ClearService
{
    private ClearInterface $storage;

    public function __construct(ClearInterface $storage)
    {
        $this->storage = $storage;
    }

    public function clear(): void
    {
        $this->storage->clear();
    }
}