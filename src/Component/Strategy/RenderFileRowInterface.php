<?php
declare(strict_types=1);

namespace App\Component\Strategy;

use App\Component\FileSystem\File;

interface RenderFileRowInterface
{
    public function render(File $file, int $level = 0): string;
}
