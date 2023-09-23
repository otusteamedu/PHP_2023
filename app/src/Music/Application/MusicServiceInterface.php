<?php

declare(strict_types=1);

namespace App\Music\Application;

use App\Music\Application\Strategy\SortIteratorStrategy\SortIteratorStrategyInterface;
use App\Music\Domain\Iterator\UploadIteratorInterface;

interface MusicServiceInterface
{
    public function createUploadIterator(array $collection, SortIteratorStrategyInterface $iteratorStrategy): UploadIteratorInterface;
}