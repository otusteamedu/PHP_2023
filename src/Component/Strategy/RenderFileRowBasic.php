<?php
declare(strict_types=1);

namespace App\Component\Strategy;

use App\Component\FileSystem\File;

class RenderFileRowBasic implements RenderFileRowInterface
{
    public function render(File $file, int $level = 0): string
    {
        return sprintf(
            '%s|-%s %s',
            str_repeat(' ', $level),
            $file->getFile()->getFilename(),
            $file->getFile()->getSize()
        );
    }
}
