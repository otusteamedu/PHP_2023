<?php

declare(strict_types=1);

namespace App\Music\Application\Iterator;

use App\Music\Application\MusicServiceInterface;

class UploadCollection implements MusicServiceInterface
{
    public function createUploadIterator(array $collection): UploadIteratorInterface
    {
        return new UploadIterator($collection);
    }
}