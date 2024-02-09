<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem\RenderStrategy;

use Yevgen87\App\Domain\FileSystem\FileSystemItemInterface;
use Yevgen87\App\Domain\RenderStrategyInterface;

class HtmlFileRenderStrategy implements RenderStrategyInterface
{
    public function render(FileSystemItemInterface $fileSystemItem): string
    {
        $d = fopen($fileSystemItem->name, 'r');

        $preview = '';

        $fileSize = filesize($fileSystemItem->name);

        if ($fileSize > 0) {
            $content = fread($d, filesize($fileSystemItem->name));
            $preview = substr(trim(str_replace(["\r\n", "\n"], "", strip_tags($content))), 0, 50);
        }

        fclose($d);

        return sprintf(
            "--%s %sb %s\n",
            basename($fileSystemItem->name),
            $fileSystemItem->getSize(),
            $preview
        );
    }
}
