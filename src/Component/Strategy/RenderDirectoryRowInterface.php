<?php
declare(strict_types=1);

namespace App\Component\Strategy;

use App\Component\FileSystem\Directory;

interface RenderDirectoryRowInterface
{
    public function render(Directory $directory, int $level = 0): string;
}
