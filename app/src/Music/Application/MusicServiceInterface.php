<?php

declare(strict_types=1);

namespace App\Music\Application;

use App\Music\Application\Iterator\UploadIteratorInterface;

interface MusicServiceInterface
{
    public function createUploadIterator(array $collection): UploadIteratorInterface;
}