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

    public abstract function render();

    public abstract function getSize(): int;
}
