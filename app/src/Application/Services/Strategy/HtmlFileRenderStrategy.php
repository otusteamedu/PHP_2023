<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\Services\Strategy;

use Yevgen87\App\Domain\FileSystemItemInterface;
use Yevgen87\App\Domain\RenderStrategyInterface;

class HtmlFileRenderStrategy implements RenderStrategyInterface
{
    public function render(FileSystemItemInterface $fileSystemItem): string
    {
        return strip_tags($fileSystemItem->name);
    }
}
