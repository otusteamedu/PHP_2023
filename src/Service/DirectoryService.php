<?php
declare(strict_types=1);

namespace App\Service;

use App\Component\Factory\RenderFileSystemFactoryInterface;
use App\Component\FileSystem\Directory;
use App\Component\FileSystem\File;
use App\Component\Strategy\RenderDirectoryRowInterface;
use App\Component\Strategy\RenderFileRowInterface;
use DirectoryIterator;
use SplFileInfo;

readonly class DirectoryService
{
    private RenderDirectoryRowInterface $renderDirectoryRow;
    private RenderFileRowInterface      $renderFileRow;

    public function __construct(RenderFileSystemFactoryInterface $renderFileSystemFactory)
    {
        $this->renderFileRow      = $renderFileSystemFactory->createRenderFileRow();
        $this->renderDirectoryRow = $renderFileSystemFactory->createRenderDirectoryRow();
    }

    public function getTreeByDirectory(string $directory): string
    {
        $directoryTree = new Directory(new SplFileInfo($directory), $this->renderDirectoryRow);
        $this->getTreeByDir($directoryTree);

        return $directoryTree->render();
    }

    private function getTreeByDir(Directory $dir): void
    {
        $directory = new DirectoryIterator($dir->getDirectory()->getRealPath());

        foreach ($directory as $file) {
            if (
                $file->getFilename() === '.'
                || $file->getFilename() === '..'
            ) {
                continue;
            }

            if ($file->getFileInfo()->isFile()) {
                $dir->add(new File($file->getFileInfo(), $this->renderFileRow));
            } else {
                $itemDirectory = new Directory($file->getFileInfo(), $this->renderDirectoryRow);
                $dir->add($itemDirectory);
                $this->getTreeByDir($itemDirectory);
            }
        }
    }
}
