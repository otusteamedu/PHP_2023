<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem\AdvancedFileSystem;

use Yevgen87\App\Application\FileSystem\FileSystemItem;
use Yevgen87\App\Domain\RenderStrategyInterface;

class File extends FileSystemItem {
    private $size;

    private RenderStrategyInterface $renderStrategy;

    public function __construct(string $name) {
        parent::__construct($name);
        // $this->size = $size;
    }

    public function size(): int {
        return $this->size;
    }

    public function render()
    {
        // echo "|--" . $this->name . "\n";
        echo $this->renderStrategy->render($this);
    }
}