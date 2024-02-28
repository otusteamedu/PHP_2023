<?php
declare(strict_types=1);

namespace App\Component\FileSystem;

interface FileInterface
{
    public function render(int $level = 0): string;

    public function isDir(): bool;
}
