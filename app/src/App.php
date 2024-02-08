<?php

declare(strict_types=1);

namespace Yevgen87\App;

use Yevgen87\App\Application\FileSystem\AdvancedFileSystem\AdvancedFileSystemFactory;
use Yevgen87\App\Application\FileSystem\BaseFileSystem\BaseFileSystemFactory;
use Yevgen87\App\Application\UseCases\FileCatalogUseCase;

class App
{
    public function run()
    {
        $path = $_SERVER['argv'][1] ?? '.';

        $mode = $_SERVER['argv'][2] ?? 1;

        $mode = $mode == 1
            ? new BaseFileSystemFactory()
            : new AdvancedFileSystemFactory();

        $useCase = new FileCatalogUseCase($mode);

        $useCase->execute($path);
    }
}
