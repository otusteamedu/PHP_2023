<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure;

use Yevgen87\App\Application\FileSystem\AdvancedFileSystemFactory;
use Yevgen87\App\Application\FileSystem\BaseFileSystemFactory;
use Yevgen87\App\Application\UseCases\FileCatalogUseCase;

class FileSystemController
{
    public function __invoke(...$arguments)
    {
        $path = $arguments[1] ?? '.';

        $mode = $arguments[2] ?? 1;

        $mode = (int)$mode === 1
            ? new BaseFileSystemFactory()
            : new AdvancedFileSystemFactory();

        $useCase = new FileCatalogUseCase($mode);

        $useCase->execute($path);
    }
}
