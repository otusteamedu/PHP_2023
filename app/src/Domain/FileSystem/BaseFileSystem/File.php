<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem\BaseFileSystem;

use Yevgen87\App\Domain\FileSystem\FileSystemItem;

class File extends FileSystemItem
{   
    /**
     * @var integer
     */
    private int $size;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->size = filesize($filePath);
    }

    /**
     * @return integer
     */
    public function getSize(): int
    {
        return $this->size;
    }
}
