<?php
declare(strict_types=1);

namespace App\Component\FileSystem;

use App\Component\Strategy\RenderDirectoryRowInterface;
use SplFileInfo;
use SplObjectStorage;

readonly class  Directory implements FileInterface
{
    private SplObjectStorage $elements;

    public function __construct(
        private SplFileInfo                 $directory,
        private RenderDirectoryRowInterface $renderDirectoryRow,
    ) {
        $this->elements = new SplObjectStorage();
    }

    public function render(int $level = 0): string
    {
        return $this->renderDirectoryRow->render($this, $level);
    }

    public function getSize(): int
    {
        $size = 0;

        foreach ($this->elements as $element) {
            /** @var File|Directory $element */
            if ($element->isDir()) {
                $size += $this->getDirectory()->getSize();
            } else {
                $size += $element->getFile()->getSize();
            }
        }

        return $size;
    }

    public function isDir(): bool
    {
        return true;
    }

    public function getDirectory(): SplFileInfo
    {
        return $this->directory;
    }

    public function add(FileInterface $file): void
    {
        if (!$this->elements->contains($file)) {
            $this->elements->attach($file);
        }
    }

    public function getElements(): SplObjectStorage
    {
        return $this->elements;
    }
}
