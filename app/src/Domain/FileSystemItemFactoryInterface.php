<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain;

use Yevgen87\App\Domain\FileSystem\FileSystemItemInterface;

interface FileSystemItemFactoryInterface
{
    public function makeFile($name): FileSystemItemInterface;

    public function makeDirectory($name, $level): FileSystemItemInterface;
}
