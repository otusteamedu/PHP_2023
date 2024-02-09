<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem\AdvancedFileSystem;

use Yevgen87\App\Domain\FileSystem\FileSystemItem;
use Yevgen87\App\Domain\RenderStrategyInterface;

class File extends FileSystemItem
{
    private $size;

    private RenderStrategyInterface $renderStrategy;

    public function __construct($name, RenderStrategyInterface $renderStrategy)
    {
        parent::__construct($name);
        $this->size = filesize($name);

        $this->renderStrategy = $renderStrategy;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function render()
    {
        echo $this->renderStrategy->render($this);
    }
}
