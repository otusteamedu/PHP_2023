<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem\AdvancedFileSystem;

use Yevgen87\App\Domain\FileSystem\FileSystemItem;
use Yevgen87\App\Domain\RenderStrategyInterface;

class File extends FileSystemItem
{
    /**
     * @var integer
     */
    private int $size;

    /**
     * @var RenderStrategyInterface
     */
    private RenderStrategyInterface $renderStrategy;

    public function __construct(string $filePath, RenderStrategyInterface $renderStrategy)
    {
        parent::__construct($filePath);
        $this->size = filesize($filePath);

        $this->renderStrategy = $renderStrategy;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->renderStrategy->render($this);
    }
}
