<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\Contract\FileStorageInterface;

class FileStorage implements FileStorageInterface
{
    private string $dir;

    public function __construct()
    {
        $this->dir = dirname(__FILE__, 4) . '/data';
    }

    public function getPathFile(string $fileName): ?string
    {
        $path = $this->dir . DIRECTORY_SEPARATOR . $fileName;
        return file_exists($path) ? $path : null;
    }
}
