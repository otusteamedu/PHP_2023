<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem;

use Yevgen87\App\Domain\FileSystemItemInterface;

abstract class FileSystemItem implements FileSystemItemInterface
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public abstract function render();

    public abstract function getSize(): int;

    public function humanFilesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen((string)$bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
}
