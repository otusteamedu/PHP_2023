<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem;

abstract class FileSystemItem implements FileSystemItemInterface
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    abstract public function render();

    abstract public function getSize(): int;
}
