<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem\RenderStrategy;

use Yevgen87\App\Domain\FileSystem\FileSystemItemInterface;
use Yevgen87\App\Domain\RenderStrategyInterface;

class TextFileRenderStrategy implements RenderStrategyInterface
{
    public function render(FileSystemItemInterface $fileSystemItem): string
    {
        $d = fopen($fileSystemItem->filePath, 'r');
        $preview = fread($d, 50);
        fclose($d);

        return sprintf(
            "|--%s %sb %s\n",
            basename($fileSystemItem->filePath),
            $fileSystemItem->getSize(),
            $preview
        );
    }
}
