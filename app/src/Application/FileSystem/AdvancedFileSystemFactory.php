<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem;

use Yevgen87\App\Application\FileSystem\RenderStrategy\BaseRenderStrategy;
use Yevgen87\App\Application\FileSystem\RenderStrategy\HtmlFileRenderStrategy;
use Yevgen87\App\Application\FileSystem\RenderStrategy\TextFileRenderStrategy;
use Yevgen87\App\Domain\FileSystem\AdvancedFileSystem\Directory;
use Yevgen87\App\Domain\FileSystem\AdvancedFileSystem\File;
use Yevgen87\App\Domain\FileSystemItemFactoryInterface;

class AdvancedFileSystemFactory implements FileSystemItemFactoryInterface
{
    public function makeFile($name): File
    {
        $renderStrategy = $this->getRenderStrategy($name);

        return new File($name, $renderStrategy);
    }

    public function makeDirectory($name, $level): Directory
    {
        return new Directory($name, $level);
    }

    private function getRenderStrategy($file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        return match ($ext) {
            'txt' => new TextFileRenderStrategy(),
            'html' => new HtmlFileRenderStrategy(),
            default => new BaseRenderStrategy(),
        };
    }
}
