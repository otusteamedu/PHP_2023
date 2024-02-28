<?php
declare(strict_types=1);

namespace App\Component\FileSystem;

use App\Component\Strategy\RenderFileRowInterface;
use SplFileInfo;

readonly class File implements FileInterface
{
    public function __construct(
        private SplFileInfo            $file,
        private RenderFileRowInterface $renderFileRow
    ) {
    }

    public function render(int $level = 0): string
    {
        return $this->renderFileRow->render($this, $level);
    }

    public function isDir(): bool
    {
        return false;
    }

    public function getFile(): SplFileInfo
    {
        return $this->file;
    }
}
