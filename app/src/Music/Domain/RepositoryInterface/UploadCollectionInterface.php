<?php

declare(strict_types=1);

namespace App\Music\Domain\RepositoryInterface;

use App\Music\Application\Iterator\UploadIteratorInterface;

interface UploadCollectionInterface
{
    public function uploadCollection(UploadIteratorInterface $iterator);
}