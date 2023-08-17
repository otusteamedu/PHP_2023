<?php

declare(strict_types=1);

namespace Art\Code\Application\Contract;

use Art\Code\Application\Dto\StorageDefinitionRequest;
use Art\Code\Domain\Model\Storage;

interface StorageDefinitionInterface
{
    public function getStorage(StorageDefinitionRequest $storage): Storage;
}
