<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain;

use Yevgen87\App\Domain\FileSystem\FileSystemItemInterface;

interface RenderStrategyInterface
{
    public function render(FileSystemItemInterface $fileSystemItem): string;
}
