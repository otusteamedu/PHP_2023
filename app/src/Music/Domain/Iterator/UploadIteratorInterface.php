<?php

declare(strict_types=1);

namespace App\Music\Domain\Iterator;

interface UploadIteratorInterface
{
    public function getNext();

    public function hasMore(): bool;
}