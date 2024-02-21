<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Repository\StorageInterface;

readonly class ClearAllEvent implements ClearAllEventInterface
{
    public function __construct(private StorageInterface $storage)
    {
    }

    public function clear(): void
    {
        $this->storage->clearAll();
    }
}
