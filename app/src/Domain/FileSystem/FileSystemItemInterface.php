<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\FileSystem;

interface FileSystemItemInterface
{
    public function getSize();

    public function render();
}
