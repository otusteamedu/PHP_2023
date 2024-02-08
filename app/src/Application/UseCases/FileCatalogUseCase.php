<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\UseCases;

use Yevgen87\App\Domain\FileSystemItemFactoryInterface;

class FileCatalogUseCase
{
    public function __construct(private readonly FileSystemItemFactoryInterface $fileSystemItemFactory)
    {
    }

    private function buildTree($path, $level = 0)
    {
        chdir($path);

        $dir = opendir('.');

        $directory = $this->fileSystemItemFactory->makeDirectory($dir, $level);

        while (($name = readdir($dir)) !== false) {

            if ($name == '.' || $name == '..') {
                continue;
            }

            // $path = $path . '/' . $name;

            if (!is_dir($name)) {

                $size = filesize($name);
                $directory->add($this->fileSystemItemFactory->makeFile($name));
            } else {
                $directory->add($this->buildTree($name, $level + 1));
            }
        }

        chdir('..');

        return $directory;
    }

    public function execute(string $path = '.')
    {
        $tree = $this->buildTree($path);

        echo $tree->render();
    }
}
