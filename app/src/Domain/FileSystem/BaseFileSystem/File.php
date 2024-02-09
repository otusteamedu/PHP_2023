<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem\BaseFileSystem;

use Yevgen87\App\Domain\FileSystem\FileSystemItem;

class File extends FileSystemItem
{
    private $size;

    public function __construct($name)
    {
        $this->name = $name;
        $this->size = filesize($name);
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function render()
    {
        echo "|--" . basename($this->name) . " (" . $this->getSize() . " b)\n";
    }
}
