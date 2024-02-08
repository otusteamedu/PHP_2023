<?php

namespace Yevgen87\App\Service\Strategy;

use Yevgen87\App\Domain\FileSystemItemInterface;
use Yevgen87\App\Domain\RenderStrategyInterface;

class TextFileRenderStrategy implements RenderStrategyInterface
{
    public function render(FileSystemItemInterface $fileSystemItem): string
    {
        return $fileSystemItem->name . ' advanced';
    }
}
