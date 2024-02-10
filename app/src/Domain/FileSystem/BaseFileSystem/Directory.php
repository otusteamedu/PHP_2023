<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem\BaseFileSystem;

use Yevgen87\App\Domain\FileSystem\FileSystemItem;

class Directory extends FileSystemItem
{
    /**
     * @var array
     */
    private array $items = [];

    /**
     * @var integer
     */
    public int $level;

    /**
     * @param string $filePath
     * @param integer $level
     */
    public function __construct(string $filePath, int $level)
    {
        $this->filePath = $filePath;
        $this->level = $level;
    }

    /**
     * @param FileSystemItem $item
     * @return void
     */
    public function add(FileSystemItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return integer
     */
    public function getSize(): int
    {
        $size = 0;

        foreach ($this->items as $item) {
            $size += $item->getSize();
        }

        return $size;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $str = parent::render();

        foreach ($this->items as $item) {
            for ($i = 0; $i < $this->level * 2; $i++) {
                $str .= "  ";
            }
            $str .= $item->render();
        }

        return $str;
    }
}
