<?php

declare(strict_types=1);

namespace Vp\App\Services;

class FileStorage
{
    private string $dir;

    public function __construct()
    {
        $this->dir = dirname(__FILE__, 3) . '/data';
    }

    public function getPathFile(string $fileName): ?string
    {
        $path = $this->dir . DIRECTORY_SEPARATOR . $fileName;
        return file_exists($path) ? $path : null;
    }
}
