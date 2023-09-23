<?php

declare(strict_types=1);

namespace App\Music\Application\Iterator;

use App\Music\Application\MusicServiceInterface;
use App\Music\Application\Strategy\SortIteratorStrategy\SortIteratorStrategyInterface;
use App\Music\Domain\Iterator\UploadIteratorInterface;

class UploadCollection implements MusicServiceInterface
{
    public function createUploadIterator(array $collection, SortIteratorStrategyInterface $iteratorStrategy): UploadIteratorInterface
    {
        return new UploadIterator($collection, $iteratorStrategy);
    }
}
