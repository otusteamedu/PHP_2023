<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem\AdvancedFileSystem;

use Yevgen87\App\Application\FileSystem\FileSystemItem;

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

    public function size(): int
    {
        $size = 0;
        foreach ($this->items as $item) {
            $size += $item->size();
        }
        return $size;
    }

    public function render()
    {
        echo "|--" . $this->name . "\n";

        foreach ($this->items as $item) {

            for ($i = 0; $i < $this->level * 2; $i++) {
                echo "  ";
            }
            echo $item->render();
        }
    }
}
