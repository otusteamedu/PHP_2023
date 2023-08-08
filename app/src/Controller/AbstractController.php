<?php

declare(strict_types=1);

namespace DEsaulenko\Hw12\Controller;

use DEsaulenko\Hw12\Storage\StorageInterface;

class AbstractController
{
    protected StorageInterface $storage;

    public function __construct(
        StorageInterface $storage
    )
    {
        $this->storage = $storage;
    }
}
