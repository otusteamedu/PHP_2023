<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\FileSystem\BaseFileSystem;

use Yevgen87\App\Domain\FileSystemItemFactoryInterface;

class BaseFileSystemFactory implements FileSystemItemFactoryInterface 
{
    public function makeFile($name): File
    {
        return new File($name);
    }

    public function makeDirectory($name, $level): Directory
    {
        return new Directory($name, $level);
    }
}