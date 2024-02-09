<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem\RenderStrategy;

use Yevgen87\App\Domain\FileSystem\FileSystemItemInterface;
use Yevgen87\App\Domain\RenderStrategyInterface;

class BaseRenderStrategy implements RenderStrategyInterface
{
    public function render(FileSystemItemInterface $fileSystemItem): string
    {
        return sprintf(
            "--%s %sb\n",
            basename($fileSystemItem->name),
            $fileSystemItem->getSize()
        );
    }
}
