<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem\BaseFileSystem;

use Yevgen87\App\Application\FileSystem\FileSystemItem;

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
        echo "|--" . $this->name . " (" . $this->humanFilesize($this->getSize()). " b)\n";
    }
    
}
