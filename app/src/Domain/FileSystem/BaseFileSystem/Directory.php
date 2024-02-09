<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem\BaseFileSystem;

use Yevgen87\App\Domain\FileSystem\FileSystemItem;

class Directory extends FileSystemItem
{
    private $items = [];

    public $level;

    public function __construct($name, $level)
    {
        $this->name = $name;
        $this->level = $level;
    }

    public function add(FileSystemItem $item)
    {
        $this->items[] = $item;
    }

    public function getSize(): int
    {
        $size = 0;

        foreach ($this->items as $item) {

            $size += $item->getSize();
        }

        return $size;
    }

    public function render()
    {
        echo "|--" . $this->name . " (" . $this->getSize() . ")\n";

        foreach ($this->items as $item) {

            for ($i = 0; $i < $this->level * 2; $i++) {
                echo "  ";
            }
            echo $item->render();
        }
    }
}
